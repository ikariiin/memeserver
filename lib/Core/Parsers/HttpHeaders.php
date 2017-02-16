<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 12/2/17
 * Time: 11:50 AM
 */

namespace memeserver\Core\Parsers;


use memeserver\Core\DataStructures\HttpHeader;
use memeserver\Core\DataStructures\KeyValuePairs;
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

    /**
     * @return HttpHeader
     */
    public function parse(): HttpHeader {
        $rawText =  $this->payload->get();
        $lines = $this->linize($rawText);
        $kVPairs = $this->getKeyValuePairs($lines);
        return new HttpHeader($kVPairs);
    }

    /**
     * @param string $rawText
     * @param string $delimiter
     * @return array
     */
    private function linize(string $rawText, string $delimiter = "\r\n"): array {
        return explode($delimiter, $rawText);
    }

    /**
     * @param array $lines
     * @return KeyValuePairs
     */
    private function getKeyValuePairs(array $lines): KeyValuePairs {
        $pairs = new KeyValuePairs();
        foreach ($lines as $key => $line) {
            if ($key === 0) {
                $ul = explode(" ", $line);
                $pairs->create("_method", $ul[0]);
                $pairs->create("_uri", $ul[1]);
                $pairs->create("_httpVersion", explode('/', $ul[2])[1]);
            } else if(strlen($line) !== 0) {
                $ul = explode(': ', $line);
                $pairs->create($ul[0], $ul[1]);
            }
        }
        return $pairs;
    }
}