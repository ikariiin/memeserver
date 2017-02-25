<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 12/2/17
 * Time: 11:56 AM
 */

namespace memeserver\Core\DataStructures;


class KeyValuePairs {
    /**
     * @var array
     */
    private $internalArray;

    /**
     * @param string|int $key
     * @param mixed $value
     * @return KeyValuePairs
     */
    public function create($key, $value): self {
        $this->internalArray[$key] = $value;
        return $this;
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

    /**
     * @return bool
     */
    public function isNull(): bool {
        return $this->internalArray == null;
    }

    /**
     * @param int|string $key
     * @return bool
     */
    public function isSet($key): bool {
        return isset($this->internalArray[$key]);
    }

    /**
     * @return array
     */
    public function getInternalRawArray(): array {
        return $this->internalArray;
    }

    /**
     * @param $value
     * @return bool
     */
    public function inArray($value) {
        return in_array($value, $this->internalArray);
    }

    /**
     * @param $key int|string
     * @return self
     */
    public function unset($key): self {
        $this->unset($this->internalArray[$key]);
        return $this;
    }
}