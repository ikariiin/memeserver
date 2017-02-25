<?php

namespace memeserver\Core\DataStructures;

/**
 * Class HttpRequest
 * @package memeserver\Core\DataStructures
 */
class HttpRequest {
    /**
     * @var HttpHeader
     */
    private $headers;

    /**
     * HttpRequest constructor.
     * @param HttpHeader $header
     */
    public function __construct(HttpHeader $header) {
        $this->headers = $header;
    }

    public function h(): HttpHeader {
        return $this->headers;
    }
}