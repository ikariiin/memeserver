<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 12/2/17
 * Time: 11:50 AM
 */

namespace memeserver\Core\Parsers;


use memeserver\Core\Payloads\RawPayload;

/**
 * Class HttpHeaders
 * @package memeserver\Core\Parsers
 */
class HttpHeaders implements Parser {
    /**
     * @var RawPayload
     */
    private $payload;

    /**
     * HttpHeaders constructor.
     * @param RawPayload $payload
     */
    public function __construct(RawPayload $payload) {
        $this->payload = $payload;
    }

    public function parse() {
        $rawText =  $this->payload->get();
        $line = $this->linize($rawText);
    }

    private function linize(string $rawText, string $delimiter = PHP_EOL): array {
        return explode($delimiter, $rawText);
    }

    private function getKeyValuePairs(array $lines) {}
}