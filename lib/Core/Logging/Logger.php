<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 5/2/17
 * Time: 10:44 PM
 */

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
    private $logMode;

    public function __construct(int $logMode, string $logFile, bool $logToConsole) {
        $this->logMode = $logMode;
    }

    public static function notifyFatal(): void {
        Console::out("Fatal Error. Exiting.");
    }

    public function exceptionHandler(\Throwable $throwable) {
        var_dump($throwable);
    }

    public function warn(int $logMode, string $warning): void {
        if($logMode > $this->logMode || $logMode == $this->logMode) {
            Console::out(Color::bgRed("WARNING") . ' ' . $warning);
        }
    }
}