<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 5/2/17
 * Time: 10:27 PM
 */

namespace memeserver\Handler;

/**
 * Interface Handler
 * @package memeserver\Handler
 */
interface Handler {
    public function __construct(RawPayload $payload);

    public function process(callable $callback);
}