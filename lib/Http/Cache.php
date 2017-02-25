<?php

namespace memeserver\Http;

use memeserver\Core\DataStructures\HttpRequest;
use memeserver\Core\DataStructures\HttpResponse;

/**
 * Class Cache
 * @package memeserver\Http
 */
class Cache implements HttpModule {
    /**
     * @var HttpRequest
     */
    private $request;

    /**
     * @var HttpResponse
     */
    private $response;

    /**
     * Cache constructor.
     * @param HttpRequest $request
     * @param HttpResponse $response
     */
    public function __construct(HttpRequest $request, HttpResponse $response) {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @param string $eTag
     * @return bool
     */
    public function check(string $eTag): bool {
        $ifModified = $this->request->h()->ifModified();
        if($ifModified !== false) {
            return $ifModified === $eTag;
        } else {
            return false;
        }
    }
}