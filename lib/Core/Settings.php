<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 5/2/17
 * Time: 10:21 PM
 */

namespace memeserver\Core;

use memeserver\Handler\Handler;

/**
 * Class Settings
 * A basic class to create a setting to be used by the server during its life
 * span.
 * @package memeserver\Core
 */
class Settings {
    /**
     * The ip to listen to.
     * @var string
     */
    private $listeningIp;

    /**
     * The port on the ip to listen to.
     * @var int
     */
    private $listeningPort;

    /**
     * The handler to call upon each request.
     * @var Handler
     */
    private $handler;

    /**
     * The directory to store logs.
     * @var string
     */
    private $logDirectory;

    /**
     * Log level, two modes are currently present
     * LOG_PRODUCTION or LOG_DEVELOPMENT
     * @var int
     */
    private $logLevel;

    /**
     * Whether to log errors to console
     * @var bool
     */
    private $logToConsole;

    /**
     * @return string
     */
    public function getListeningIp(): string {
        return $this->listeningIp;
    }

    /**
     * @param string $listeningIp
     * @return Settings
     */
    public function setListeningIp(string $listeningIp): self {
        $this->listeningIp = $listeningIp;
        return $this;
    }

    /**
     * @return int
     */
    public function getListeningPort(): int {
        return $this->listeningPort;
    }

    /**
     * @param int $listeningPort
     * @return Settings
     */
    public function setListeningPort(int $listeningPort): self {
        $this->listeningPort = $listeningPort;
        return $this;
    }

    /**
     * @return Handler
     */
    public function getHandler(): Handler {
        return $this->handler;
    }

    /**
     * @param Handler $handler
     * @return Settings
     */
    public function setHandler(Handler $handler): self {
        $this->handler = $handler;
        return $this;
    }

    /**
     * @return string
     */
    public function getLogDirectory(): string {
        return $this->logDirectory;
    }

    /**
     * @param string $logDirectory
     * @return Settings
     */
    public function setLogDirectory(string $logDirectory): self {
        $this->logDirectory = $logDirectory;
        return $this;
    }

    /**
     * @return int
     */
    public function getLogLevel(): int {
        return $this->logLevel;
    }

    /**
     * @param int $logLevel
     * @return Settings
     */
    public function setLogLevel(int $logLevel): self {
        $this->logLevel = $logLevel;
        return $this;
    }

    /**
     * @param bool $logToConsole
     * @return Settings
     */
    public function setLogToConsole(bool $logToConsole): Settings {
        $this->logToConsole = $logToConsole;
        return $this;
    }

    /**
     * @return bool
     */
    public function isLogToConsole(): bool {
        return $this->logToConsole;
    }
}