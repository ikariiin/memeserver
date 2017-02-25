<?php

namespace memeserver\Core\Threading;


use memeserver\Handler\Handler;

class HandlerWork extends \Threaded {
    /**
     * @var Handler
     */
    private $handler;

    /**
     * HandlerWork constructor.
     * @param Handler $handler
     */
    public function __construct(Handler $handler) {
        $this->handler = $handler;
    }

    public function run() {
        $this->handler->start($this);
    }
}