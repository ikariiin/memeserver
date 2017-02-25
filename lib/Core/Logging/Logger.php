<?php

namespace memeserver\Core\Logging;

use memeserver\Core\IO\Console\Color;
use memeserver\Core\IO\Console\Console;

/**
 * Class Logger
 * The object would be retained across
 * the life span of the application in runtime
 * @package memeserver\Core\Logging
 */
class Logger {
    /**
     * @var int
     */
    private $logMode;

    /**
     * Logger constructor.
     * @param int $logMode
     * @param string $logFile
     * @param bool $logToConsole
     */
    public function __construct(int $logMode, string $logFile, bool $logToConsole) {
        $this->logMode = $logMode;
    }

    /**
     * Notifies exit of app.
     */
    public static function notifyFatal(): void {
        Console::out("Fatal Error. Exiting.");
    }

    /**
     * @param \Throwable $throwable
     */
    public function exceptionHandler(\Throwable $throwable) {
        var_dump($throwable);
    }

    /**
     * @param int $logMode
     * @param string $warning
     */
    public function warn(int $logMode, string $warning): void {
        if($logMode > $this->logMode || $logMode == $this->logMode) {
            Console::out(Color::bgPurple("WARNING") . ' ' . $warning);
        }
    }

    /**
     * @param int $logMode
     * @param string $crit
     */
    public function critical(int $logMode, string $crit): void {
        if($logMode > $this->logMode || $logMode == $this->logMode) {
            Console::out(Color::bgRed("WARNING") . ' ' . $crit);
        }
    }
}