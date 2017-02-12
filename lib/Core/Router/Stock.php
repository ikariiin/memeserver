<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 10/2/17
 * Time: 5:02 PM
 */

namespace memeserver\Core\Router;

use memeserver\Core\Parsers\DocBlock;

/**
 * Class Stock
 * @package memeserver\Core\Router
 */
abstract class Stock implements Router {
    public function route(string $method, string $uri) {
    }
}