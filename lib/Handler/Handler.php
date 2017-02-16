<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 5/2/17
 * Time: 10:27 PM
 */

namespace memeserver\Handler;

use memeserver\Core\Payloads\RawPayload;
use memeserver\Core\StreamSocket\ThreadSafeStream;

/**
 * Interface Handler
 * @package memeserver\Handler
 */
interface Handler {
    /**
     * @param RawPayload $payload
     */
    public function setRawPayload(RawPayload $payload);

    /**
     * @param callable $callback
     */
    public function setCallback(callable $callback);

    /**
     * @param ThreadSafeStream $stream
     */
    public function setStream(ThreadSafeStream $stream);
}