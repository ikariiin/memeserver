<?php

namespace memeserver\Handler;

use memeserver\Core\DataStructures\HttpHeader;
use memeserver\Core\DataStructures\HttpRequest;
use memeserver\Core\DataStructures\HttpResponse;
use memeserver\Core\DataStructures\RouteData;
use memeserver\Core\Logging\Logger;
use memeserver\Core\Logging\LogMode;
use memeserver\Core\Parsers\HttpHeaders;
use memeserver\Core\Payloads\RawPayload;
use memeserver\Core\Settings;
use memeserver\Core\StreamSocket\ThreadSafeStream;
use memeserver\Core\Threading\Dispatcher;
use memeserver\Core\Threading\ParallelOperation;
use memeserver\Http\Cache;

class Http implements ParallelOperation, Handler {
    /**
     * @var RawPayload
     */
    private $payload;

    /**
     * @var \Socket
     */
    private $socket;

    /**
     * @var Settings
     */
    private $settings;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var HttpHeader
     */
    private $headers;

    /**
     * @var HttpRequest
     */
    private $request;

    /**
     * @param Logger $logger
     * @return $this
     */
    public function setLogger(Logger $logger) {
        $this->logger = $logger;
        return $this;
    }

    /**
     * @param RawPayload $payload
     * @return $this
     */
    public function setRawPayload(RawPayload $payload) {
        $this->payload = $payload;
        return $this;
    }

    /**
     * @param callable $callback
     * @return $this
     */
    public function setCallback(callable $callback) {
        return $this;
    }

    /**
     * @param Settings $settings
     * @return $this
     */
    public function setSettings(Settings $settings) {
        $this->settings = $settings;
        return $this;
    }

    /**
     * @param \Socket $socket
     * @return $this
     */
    public function setSocket(\Socket $socket) {
        $this->socket = $socket;
        return $this;
    }

    /**
     * Method to indicate the start of the process
     * in a newly created thread.
     * @param Dispatcher $dispatcher
     * @return void
     */
    public function start(Dispatcher $dispatcher): void {
        $httpParser = new HttpHeaders($this->payload);
        $headers = $httpParser->parse();

        $this->headers = $headers;
        $this->request = new HttpRequest($headers);

        $response = $this->callRouter($headers);

        $response = $this->buildResponse($response);

        $this->end($response);

        $dispatcher->join();
    }

    /**
     * @param HttpHeader $headers
     * @return HttpResponse
     */
    private function callRouter(HttpHeader $headers): HttpResponse {
        $router = $this->settings->getRouter();
        $route = $router->route($headers->getHttpMethod(), $headers->getHttpUri());

        if(!$route) {
            return $this->handle404();
        }

        $routeData = (new RouteData())
            ->setRequest($this->request)
            ->setResponse((new HttpResponse($this->logger, $this->request, $this->settings)));

        $response = $route['callable']($routeData);

        if(!$response instanceof HttpResponse) {
            $this->logger->critical(LogMode::LOG_DEVELOPMENT, "Return type of handler, must be `HttpResponse`, " . gettype($response) . " given.");
        }

        return $response;
    }

    /**
     * @param HttpResponse $response
     * @return HttpResponse
     */
    private function buildResponse(HttpResponse $response): HttpResponse {
        // ETag

        $etag = $response->createRequestETag();

        if($this->cached($etag, $response)) {
            $response
                ->setBody('')
                ->setStatus(302)
                ->setContentLength();
        } else {
            // Create Cache
            $response
                ->setETag($etag);
        }

        // Content-Length

        $response->setContentLength();

        return $response;
    }

    /**
     * @param string $etag
     * @param HttpResponse $response
     * @return bool
     */
    private function cached(string $etag, HttpResponse $response): bool {
        $cache = new Cache($this->request, $response);
        return $cache->check($etag);
    }

    /**
     * @param HttpResponse $response
     * @return \Socket
     */
    private function end(HttpResponse $response) {
        $rawResponse = $response->getRawResponse();
        try {
            $this->socket->write($rawResponse, strlen($rawResponse));
        } catch (\Throwable $throwable) {
            var_dump($throwable->getMessage(), $throwable->getTraceAsString());
        }
        $this->socket->close();

        return $this->socket;
    }
}