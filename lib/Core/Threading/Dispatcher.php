<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 11/2/17
 * Time: 5:36 PM
 */

namespace memeserver\Core\Threading;


/**
 * Class Dispatcher
 * @package memeserver\Core\Threading
 */
class Dispatcher extends \Thread {
    /**
     * @var callable
     */
    private $operation;

    /**
     * Dispatcher constructor.
     * @param ParallelOperation $operation
     * @internal param callable $toCall
     */
    public function __construct(ParallelOperation $operation) {
        $this->operation = $operation;
    }

    /**
     * Multithreading FTW!
     */
    public function run() {
        $this->operation->start($this);
    }
}