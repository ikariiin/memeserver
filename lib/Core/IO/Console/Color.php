<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 8/2/17
 * Time: 2:53 PM
 */

namespace memeserver\Core\IO\Console;


class Color {
    public static function red(string $str) {
        return sprintf("\033[31m %s \033[0m");
    }
}