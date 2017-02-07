<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 5/2/17
 * Time: 10:17 PM
 */

namespace memeserver;

use memeserver\Core\Listener;
use memeserver\Core\Logging\Logger;
use memeserver\Core\Settings;

/**
 * Class Initiator
 * Initiates the process of the webserver listening.
 * @package memeserver
 */
class Initiator {
    /**
     * The settings object
     * @var Settings
     */
    private $settings;

    public function __construct(Settings $settings) {
        $this->settings = clone $settings;
    }

    /**
     * Returns the logger, which
     * is to be retained.
     * @return Logger
     */
    public function getLogger(): Logger {
        return (new Logger(
            $this->settings->getLogLevel(),
            $this->settings->getLogDirectory(),
            $this->settings->isLogToConsole()
        ));
    }

    public function getListener() {
        return (new Listener($this->settings));
    }
}