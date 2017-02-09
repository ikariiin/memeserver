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
    public static function out(string $output) {
        print $output;
    }
}