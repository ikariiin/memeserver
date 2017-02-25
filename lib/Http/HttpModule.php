<?php

namespace memeserver\Http;

use memeserver\Core\DataStructures\HttpRequest;
use memeserver\Core\DataStructures\HttpResponse;

/**
 * Interface Cache
 * @package memeserver\Http
 */
interface HttpModule {
    public function __construct(HttpRequest $request, HttpResponse $response);
}