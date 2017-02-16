<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 8/2/17
 * Time: 2:47 PM
 */

namespace memeserver\Core\IO\Console;

/**
 * Class Console
 * @package memeserver\Core\IO
 */
class Console {
    /**
     * A new line
     */
    const NEW_LINE = PHP_EOL;

    /**
     * @param string $output
     * @return void
     */
    public static function out(string $output): void {
        print "\033[33m" . date("[ D, d M Y H:i:s ]") . "\033[0m " . $output . "\n";
    }
}