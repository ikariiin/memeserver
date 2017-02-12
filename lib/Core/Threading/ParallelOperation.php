<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 11/2/17
 * Time: 5:41 PM
 */

namespace memeserver\Core\Threading;


interface ParallelOperation {
    /**
     * Method to indicate the start of the process
     * in a newly created thread.
     * @param Dispatcher $dispatcher
     * @return void
     */
    public function start(Dispatcher $dispatcher): void;
}