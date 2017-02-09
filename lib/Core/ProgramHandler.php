<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 8/2/17
 * Time: 2:45 PM
 */

namespace memeserver\Core;

/**
 * Class ProgramHandler
 * @package memeserver\Core
 */
class ProgramHandler {
    public static function exit() {
        /*
         * It might be later needed to free all the resources here
         * we have used, as we are in parallel processing territory.
         */
        exit;
    }
}