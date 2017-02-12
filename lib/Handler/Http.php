<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 11/2/17
 * Time: 3:01 PM
 */

namespace memeserver\Handler;


use memeserver\Core\Payloads\RawPayload;
use memeserver\Core\Threading\Dispatcher;
use memeserver\Core\Threading\ParallelOperation;

class Http implements Handler, ParallelOperation {
    private $payload;
    /**
     * @param RawPayload $payload
     */
    public function setRawPayload(RawPayload $payload) {
        $this->payload = $payload;
    }

    /**
     * @param callable $callback
     */
    public function setCallback(callable $callback) {
    }

    /**
     * Method to indicate the start of the process
     * in a newly created thread.
     * @param Dispatcher $dispatcher
     * @return void
     */
    public function start(Dispatcher $dispatcher): void {
        $dispatcher->join();
    }
}