<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 6/2/17
 * Time: 3:06 PM
 */

namespace memeserver\Core;


use memeserver\Core\Logging\Logger;
use memeserver\Core\Payloads\RawPayload;
use memeserver\Core\StreamSocket\ThreadSafeStream;
use memeserver\Core\Threading\Dispatcher;
use memeserver\Handler\Http;

/**
 * Class Watcher
 * @package memeserver\Core
 */
class Watcher {
    /**
     * @var ThreadSafeStream
     */
    private $activeParentStream;
    /**
     * @var Logger
     */
    private $logger;

    /**
     * Watcher constructor.
     * @param Settings $settings
     * @param ThreadSafeStream $stream
     * @param Logger $logger
     */
    public function __construct(Settings $settings, ThreadSafeStream $stream, Logger $logger) {
        $this->activeParentStream = $stream;
        $this->logger = $stream;
    }

    public function start() {
        do {
            $client = $this->activeParentStream->accept();

            if(!$client)
                continue;

            $http = new Http();
            $http->setRawPayload((new RawPayload($client->read(4096))));
            $dispatcher = new Dispatcher($http);
            $dispatcher->start();
        } while (true);
    }
}