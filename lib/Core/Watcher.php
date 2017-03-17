<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 6/2/17
 * Time: 3:06 PM
 */

namespace memeserver\Core;

include_once __DIR__ . '/../ThreadSafeIncluder.php';

use memeserver\Core\IO\Console\Console;
use memeserver\Core\Logging\Logger;
use memeserver\Core\Payloads\RawPayload;
use memeserver\Core\StreamSocket\ThreadSafeStream;
use memeserver\Core\Threading\ConnectionSpawner;
use memeserver\Core\Threading\Dispatcher;
use memeserver\Core\Threading\HandlerWork;
use memeserver\Core\Threading\ParallelOperation;
use memeserver\Handler\Handler;
use memeserver\Handler\Http;

/**
 * Class Watcher
 * @package memeserver\Core
 */
class Watcher implements ParallelOperation {
    /**
     * @var \Socket
     */
    private $socket;
    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var Settings
     */
    private $settings;

    /**
     * Watcher constructor.
     * @param Settings $settings
     * @param \Socket $socket
     * @param Logger $logger
     */
    public function __construct(Settings $settings, \Socket $socket, Logger $logger) {
        $this->socket = $socket;
        $this->logger = $logger;
        $this->settings = $settings;
    }

    public function start(Dispatcher $dispatcher): void {
        Console::out("Started Watching on stream#" . ((int) $this->socket));

        do {
            $this->socket->listen(10);

            $client = $this->socket->accept();

            if(!$client)
                continue;

            $peerDetails = $client->getPeerName();

            Console::out("Accepted Connection " . $peerDetails['host'] . '#' . $peerDetails['port']);

            /**
             * @var $handler Handler
             */
            $handler = ($this->settings->getHandler());
            $handler->setLogger($this->logger);
            $handler->setRawPayload((new RawPayload($client->read(16384))));
            $handler->setCallback(function () {});
            $handler->setSocket($client);
            $handler->setSettings($this->settings);

            $dispatcher = new Dispatcher($handler);
            $dispatcher->start();
        } while (true);
    }
}