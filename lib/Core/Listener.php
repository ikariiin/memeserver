<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 6/2/17
 * Time: 3:40 PM
 */

namespace memeserver\Core;


use memeserver\Core\Logging\BasicError;
use memeserver\Core\Logging\Logger;
use memeserver\Core\StreamSocket\ThreadSafeStream;
use memeserver\Core\Threading\Dispatcher;
use memeserver\Handler\Handler;

class Listener {
    /**
     * Ip to listen on.
     * @var string
     */
    private $ip;

    /**
     * Port on the ip to listen to.
     * @var int
     */
    private $port;

    /**
     * The handler to call upon receiving
     * a connection.
     * @var Handler
     */
    private $handler;

    /**
     * The parent stream
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
     * Listener constructor.
     * @param Settings $settings
     * @param Logger $logger
     */
    public function __construct(Settings $settings, Logger $logger) {
        $this->settings = $settings;
        $this->ip = $settings->getListeningIp();
        $this->port = $settings->getListeningPort();
        $this->handler = $settings->getHandler();
        $this->logger = $logger;
    }

    /**
     * @return ThreadSafeStream|bool
     */
    public function initListening() {
        $activeParentStream = (new ThreadSafeStream($this->logger))
            ->createServer(sprintf("%s://%s:%s",
                "tcp",
                $this->ip,
                $this->port
            ));

        if($activeParentStream instanceof BasicError) {
            $activeParentStream->log();
            Logger::notifyFatal();
            return false;
        } else {
            $this->activeParentStream = $activeParentStream;
            return $activeParentStream;
        }
    }

    /**
     * Start watching
     */
    public function startWatcher() {
        $watcher = new Watcher($this->settings, $this->activeParentStream, $this->logger);
        (new Dispatcher($watcher))
            ->start();
    }
}