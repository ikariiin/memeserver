<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 11/2/17
 * Time: 3:01 PM
 */

namespace memeserver\Handler;

use memeserver\Core\DataStructures\HttpHeader;
use memeserver\Core\Parsers\HttpHeaders;
use memeserver\Core\Payloads\RawPayload;
use memeserver\Core\Settings;
use memeserver\Core\StreamSocket\ThreadSafeStream;
use memeserver\Core\Threading\Dispatcher;
use memeserver\Core\Threading\ParallelOperation;

class Http implements Handler, ParallelOperation {
    /**
     * @var RawPayload
     */
    private $payload;

    /**
     * @var ThreadSafeStream
     */
    private $stream;

    /**
     * @var Settings
     */
    private $settings;

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
     * @return Http
     */
    public function setSettings(Settings $settings): self {
        $this->settings = $settings;
        return $this;
    }

    /**
     * @param ThreadSafeStream $stream
     * @return $this
     */
    public function setStream(ThreadSafeStream $stream) {
        $this->stream = $stream;
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
        $this->callRouter($headers);
    }

    /**
     * @param HttpHeader $headers
     */
    private function callRouter(HttpHeader $headers) {
        $router = $this->settings->getRouter();
        $router->route($headers->getHttpMethod(), $headers->getHttpUri());
    }
}