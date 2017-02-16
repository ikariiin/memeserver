<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 8/2/17
 * Time: 2:53 PM
 */

namespace memeserver\Core\IO\Console;


/**
 * Class Color
 * @package memeserver\Core\IO\Console
 */
class Color {
    /**
     * @param string $ansiEscapeSeq
     * @param string $string
     * @return string
     */
    private static function format(string $ansiEscapeSeq, string $string) {
        return sprintf("%s %s \033[0m", $ansiEscapeSeq, $string);
    }

    /**
     * @param string $str
     * @return string
     */
    public static function red(string $str): string {
        return static::format("\033[31m", $str);
    }

    /**
     * @param string $str
     * @return string
     */
    public static function bgRed(string $str): string {
        return static::format("\033[45m", $str);
    }
}