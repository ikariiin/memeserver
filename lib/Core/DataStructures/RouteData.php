<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 14/2/17
 * Time: 11:04 PM
 */

namespace memeserver\Core\DataStructures;

/**
 * Class RouteData
 * @package memeserver\Core\DataStructures
 */
class RouteData {
    /**
     * @var HttpRequest
     */
    private $request;

    /**
     * @var HttpResponse
     */
    private $response;

    /**
     * @var array
     */
    private $args;

    /**
     * @param HttpRequest $request
     * @return RouteData
     */
    public function setRequest(HttpRequest $request): RouteData {
        $this->request = $request;
        return $this;
    }

    /**
     * @param HttpResponse $response
     * @return RouteData
     */
    public function setResponse(HttpResponse $response): RouteData {
        $this->response = $response;
        return $this;
    }

    /**
     * @param array $args
     * @return RouteData
     */
    public function setArgs(array $args): RouteData {
        $this->args = $args;
        return $this;
    }

    /**
     * @return array
     */
    public function getArgs(): array {
        return $this->args;
    }

    /**
     * @return HttpResponse
     */
    public function getResponse(): HttpResponse {
        return $this->response;
    }

    /**
     * @return HttpRequest
     */
    public function getRequest(): HttpRequest {
        return $this->request;
    }
}