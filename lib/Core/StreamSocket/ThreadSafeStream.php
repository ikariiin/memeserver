<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 6/2/17
 * Time: 4:51 PM
 */

namespace memeserver\Core\StreamSocket;


use memeserver\Core\Logging\BasicError;
use memeserver\Core\Logging\Logger;

class ThreadSafeStream extends \Threaded {
    /**
     * @var resource
     */
    private $stream;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * ThreadSafeStream constructor.
     * @param Logger $logger
     */
    public function __construct(Logger $logger) {
        $this->logger = $logger;
    }

    /**
     * @param $stream
     */
    public function createFromExistingStream($stream) {
        $this->stream = $stream;
    }

    /**
     * @param string $connectionString
     * @return BasicError|self
     */
    public function createServer(string $connectionString) {
        $this->stream = stream_socket_server($connectionString, $errNo, $errStr);

        if($errNo != 0)
            return (new BasicError($this->logger, $errNo, $errStr));
        else
            return $this;

    }
}