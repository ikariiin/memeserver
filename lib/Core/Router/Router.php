<?php

namespace memeserver\Core\Router;

use memeserver\Core\Logging\Logger;

/**
 * Interface Router
 * @package memeserver\Core\Router
 */
interface Router {
    public function init(Logger $logger);
    public function route(string $method, string $uri);
}