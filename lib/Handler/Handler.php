<?php

namespace memeserver\Handler;

use memeserver\Core\Logging\Logger;
use memeserver\Core\Payloads\RawPayload;
use memeserver\Core\Settings;
use memeserver\Core\StreamSocket\ThreadSafeStream;

/**
 * Interface Handler
 * @package memeserver\Handler
 */
interface Handler {
    /**
     * @param Logger $logger
     */
    public function setLogger(Logger $logger);

    /**
     * @param RawPayload $payload
     */
    public function setRawPayload(RawPayload $payload);

    /**
     * @param callable $callback
     */
    public function setCallback(callable $callback);

    /**
     * @param \Socket $socket
     */
    public function setSocket(\Socket $socket);

    /**
     * @param $settings Settings
     */
    public function setSettings(Settings $settings);
}