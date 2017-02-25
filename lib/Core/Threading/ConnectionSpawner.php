<?php

namespace memeserver\Core\Threading;


use memeserver\Handler\Handler;

class ConnectionSpawner extends \Worker {

    /**
     * ConnectionSpawner constructor.
     */
    public function __construct() {
    }

    /**
     * @return void
     */
    public function run() {
        var_dump($this);
    }
}