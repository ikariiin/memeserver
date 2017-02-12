<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 12/2/17
 * Time: 11:56 AM
 */

namespace memeserver\Core\DataStructures;


class KeyValuePairs {
    private $internalArray;

    /**
     * @param string|int $key
     * @param mixed $value
     * @return void
     */
    public function create($key, $value): void {
        $this->internalArray[$key] = $value;
    }

    /**
     * @param string|int $key
     */
    public function delete($key): void {
        unset($this->internalArray[$key]);
    }

    /**
     * @param string|int $key
     * @return mixed
     */
    public function get($key) {
        return $this->internalArray[$key];
    }
}