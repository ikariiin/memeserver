<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 15/2/17
 * Time: 5:39 PM
 */

namespace memeserver\Core\Router;

use memeserver\Core\DataStructures\KeyValuePairs;

/**
 * Class RegexBasedUri
 * @package memeserver\Core\Router
 */
class RegexBasedUri {
    /** @var string */
    private $uri;

    /**
     * @var string
     */
    private $regexUri;

    /**
     * @var array
     */
    private $params;

    /**
     * RegexBasedUri constructor.
     * @param string $originalUri
     * @param string $regexUri
     * @param array $params
     */
    public function __construct(string $originalUri, string $regexUri, array $params) {
        $this->uri = $originalUri;
        $this->regexUri = $regexUri;
        $this->params = $params;
    }

    public function getRawUri(): string {
        return $this->uri;
    }

    public function getRegexUri(): string {
        return $this->regexUri;
    }

    public function getParameters(): array {
        return $this->params;
    }
}