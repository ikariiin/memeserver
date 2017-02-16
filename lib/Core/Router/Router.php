<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 10/2/17
 * Time: 4:52 PM
 */

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