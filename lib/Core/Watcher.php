<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 6/2/17
 * Time: 3:06 PM
 */

namespace memeserver\Core;


use memeserver\Core\StreamSocket\ThreadSafeStream;

class Watcher {
    public function __construct(ThreadSafeStream $stream) {
        $this->activeParentStream = $stream;
    }
}