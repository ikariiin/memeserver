<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 6/2/17
 * Time: 3:40 PM
 */

namespace memeserver\Core;


use memeserver\Core\IO\Console\Console;
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
     * @var $socket
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
     * @return \Socket
     */
    public function initListening() {
        $socket = new \Socket(\Socket::AF_INET, \Socket::SOCK_STREAM, \Socket::SOL_TCP);
        $socket->bind($this->ip, $this->port);

        Console::out("Listening on {$this->ip}:{$this->port}");

        $this->socket = $socket;
        return $socket;
    }

    /**
     * Start watching
     */
    public function startWatcher() {
        $watcher = new Watcher($this->settings, $this->socket, $this->logger);
        (new Dispatcher($watcher))
            ->start();
    }
}