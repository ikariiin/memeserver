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
     * @return $this
     */
    public function createFromExistingStream($stream) {
        $this->stream = $stream;

        return $this;
    }

    /**
     * @param string $connectionString
     * @return BasicError|self
     */
    public function createServer(string $connectionString) {
        $this->stream = stream_socket_server($connectionString, $errNo, $errStr);

        if($errStr !== "")
            return (new BasicError($this->logger, $errNo, $errStr));
        else
            return $this;

    }

    /**
     * @return bool|self
     */
    public function accept() {
        $acceptedStream = @stream_socket_accept($this->stream);
        if($acceptedStream != false) {
            return (new ThreadSafeStream($this->logger))
                ->createFromExistingStream($acceptedStream);
        } else {
            return false;
        }
    }

    /**
     * @param int $size
     * @return string
     */
    public function read(int $size) {
        return fread($this->stream, $size);
    }

    /**
     * @return resource
     */
    public function getRawSocket() {
        return $this->stream;
    }

    /**
     * @return string
     */
    public function getPeerDetails(): string {
        return stream_socket_get_name($this->stream, true);
    }
}