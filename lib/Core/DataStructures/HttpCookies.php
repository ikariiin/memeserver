<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 13/2/17
 * Time: 10:39 PM
 */

namespace memeserver\Core\DataStructures;

/**
 * Class HttpCookies
 * @package memeserver\Core\DataStructures
 */
class HttpCookies {
    /**
     * @var KeyValuePairs
     */
    private $rawPairs;

    /**
     * HttpCookies constructor.
     * @param KeyValuePairs $rawPairs
     */
    public function __construct(KeyValuePairs $rawPairs) {
        $this->rawPairs = $rawPairs;
    }

    /**
     * @param string $name
     * @return string
     */
    public function get(string $name) {
        return $this->rawPairs->get($name);
    }
}