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
    private $socket;

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
        $this->socket = $stream;

        return $this;
    }

    /**
     * @param string $ip
     * @param int $port
     * @return ThreadSafeStream
     */
    public function createServer(string $ip, int $port) {
        $this->socket = new \Socket(\Socket::AF_INET, \Socket::SOCK_STREAM, \Socket::SOL_TCP);
        $this->socket->bind($ip, $port);

        return $this;
    }

    /**
     * @return bool|self
     */
    public function accept() {
        $acceptedStream = @stream_socket_accept($this->socket);
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
        return fread($this->socket, $size);
    }

    /**
     * @return resource
     */
    public function getRawSocket() {
        return $this->socket;
    }

    /**
     * @return string
     */
    public function getPeerDetails(): string {
        return stream_socket_get_name($this->socket, true);
    }

    /**
     * @param $data
     * @return int
     */
    public function write($data) {
        return fwrite($this->socket, $data);
    }

    /**
     * @return bool
     */
    public function close() {
        return fclose($this->socket);
    }
}