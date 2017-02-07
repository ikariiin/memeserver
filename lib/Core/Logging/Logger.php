<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 5/2/17
 * Time: 10:44 PM
 */

namespace memeserver\Core\Logging;

/**
 * Class Logger
 * The object would be retained across
 * the life span of the application in runtime
 * @package memeserver\Core\Logging
 */
class Logger {
    private $logMode;

    public function __construct(int $logMode, string $logFile, bool $logToConsole) {
        $this->logMode = $logMode;
    }

    public function exceptionHandler(\Throwable $throwable) {}
}