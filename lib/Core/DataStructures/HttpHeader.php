<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 13/2/17
 * Time: 10:12 PM
 */

namespace memeserver\Core\DataStructures;

/**
 * Class HttpHeader
 * @package memeserver\Core\DataStructures
 */
class HttpHeader {
    /**
     * @var KeyValuePairs
     */
    private $pairs;

    /**
     * HttpHeader constructor.
     * @param KeyValuePairs $keyValuePairs
     */
    public function __construct(KeyValuePairs $keyValuePairs) {
        $this->pairs = $keyValuePairs;
    }

    /**
     * @return KeyValuePairs
     */
    public function getRawPair(): KeyValuePairs {
        return $this->pairs;
    }

    /**
     * @return string
     */
    public function getHttpMethod(): string {
        return $this->pairs->get("_method");
    }

    /**
     * @return string
     */
    public function getHttpUri(): string {
        return $this->pairs->get("_uri");
    }

    /**
     * @return string
     */
    public function getHttpVersion(): string {
        return $this->pairs->get("_httpVersion");
    }

    /**
     * @return string
     */
    public function getHost(): string {
        return $this->pairs->get("Host");
    }

    /**
     * @return string
     */
    public function getConnectionType(): string {
        return $this->pairs->get("Connection");
    }

    /**
     * @return KeyValuePairs
     */
    public function getCacheControl(): KeyValuePairs {
        $options = new KeyValuePairs();
        $rawCacheControl = $this->pairs->get("Cache-Control");
        $ul = explode(',', $rawCacheControl);
        foreach ($ul as $key => $option) {
            $options->create($key, $option);
        }

        return $options;
    }

    /**
     * @return string
     */
    public function getUserAgent(): string  {
        return $this->pairs->get("User-Agent");
    }

    /**
     * @return KeyValuePairs
     */
    public function getAcceptedFormats(): KeyValuePairs {
        $accepts = new KeyValuePairs();
        $rawAccepts = $this->pairs->get("Accept");
        $ul = explode(',', $rawAccepts);
        foreach ($ul as $key => $accept) {
            $accepts->create($key, $accept);
        }

        return $accepts;
    }

    /**
     * @return KeyValuePairs
     */
    public function getAcceptedEncoding(): KeyValuePairs {
        $accepts = new KeyValuePairs();
        $rawAccepts = $this->pairs->get("Accept-Encoding");
        $ul = explode(',', $rawAccepts);
        foreach ($ul as $key => $accept) {
            $accepts->create($key, $accept);
        }

        return $accepts;
    }

    /**
     * @return KeyValuePairs
     */
    public function getAcceptedLanguage(): KeyValuePairs {
        $accepts = new KeyValuePairs();
        $rawAccepts = $this->pairs->get("Accept-Language");
        $ul = explode(',', $rawAccepts);
        foreach ($ul as $key => $accept) {
            $accepts->create($key, $accept);
        }

        return $accepts;
    }

    /**
     * @return HttpCookies
     */
    public function getCookies(): HttpCookies {
        $rawPairs = new KeyValuePairs();
        $rawCookieHeader = $this->pairs->get("Cookie");
        $ul = explode('; ', $rawCookieHeader);
        foreach ($ul as $cookie) {
            $cookiePairs = explode('=', $cookie);
            $rawPairs->create($cookiePairs[0], $cookiePairs[1]);
        }

        return new HttpCookies($rawPairs);
    }
}