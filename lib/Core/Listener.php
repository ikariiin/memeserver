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
     * @return BasicError|ThreadSafeStream
     */
    public function initListening() {
        $this->activeParentStream = (new ThreadSafeStream($this->logger))
            ->createServer(sprintf("%s://%s:%s",
                "tcp",
                $this->ip,
                $this->port
            ));

        if($this->activeParentStream instanceof BasicError) {
            $this->activeParentStream->log();
            Logger::notifyFatal();
            ProgramHandler::exit();
            exit;
        }

        return $this->activeParentStream;
    }

    public function getWatcher() {
        return new Watcher($this->settings, $this->activeParentStream, $this->logger);
    }
}