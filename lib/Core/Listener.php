<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 6/2/17
 * Time: 3:40 PM
 */

namespace memeserver\Core;


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

    public function __construct(Settings $settings) {
        $this->ip = $settings->getListeningIp();
        $this->port = $settings->getListeningPort();
        $this->handler = $settings->getHandler();
    }

    public function listen() {
    }
}