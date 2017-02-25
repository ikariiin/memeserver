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
use memeserver\Handler\Http;

/**
 * Class Watcher
 * @package memeserver\Core
 */
class Watcher implements ParallelOperation {
    /**
     * @var ThreadSafeStream
     */
    private $activeParentStream;
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
     * @param ThreadSafeStream $stream
     * @param Logger $logger
     */
    public function __construct(Settings $settings, ThreadSafeStream $stream, Logger $logger) {
        $this->activeParentStream = $stream;
        $this->logger = $logger;
        $this->settings = $settings;
    }

    public function start(Dispatcher $dispatcher): void {
        Console::out("Started Watching on stream#" . ((int) $this->activeParentStream->getRawSocket()));

        $pool = new \Pool(4, ConnectionSpawner::class);
        do {
            $client = $this->activeParentStream->accept();

            if(!$client)
                continue;

            Console::out("Accepted Connection " . $client->getPeerDetails());

            $handler = ($this->settings->getHandler())
                ->setRawPayload((new RawPayload($client->read(4096))))
                ->setLogger($this->logger)
                ->setStream($client)
                ->setSettings($this->settings);

            //$dispatcher = new Dispatcher($http);
            //$dispatcher->start();

            $pool->submit((new HandlerWork($handler)));
        } while (true);
    }
}