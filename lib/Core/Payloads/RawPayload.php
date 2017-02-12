<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 9/2/17
 * Time: 4:08 PM
 */

namespace memeserver\Core\Payloads;


class RawPayload {
    /**
     * @var string
     */
    private $payload;

    /**
     * RawPayload constructor.
     * @param string $payload
     */
    public function __construct(string $payload) {
        $this->payload = $payload;
    }

    /**
     * @return string
     */
    public function get() {
        return $this->payload;
    }
}