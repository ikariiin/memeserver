<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 11/2/17
 * Time: 2:05 PM
 */

namespace memeserver\Core\Parsers;


use memeserver\Core\DataStructures\KeyValuePairs;

class DocBlock {
    /**
     * @param $class
     * @param string $method
     * @return KeyValuePairs
     */
    public function parse($class, string $method): KeyValuePairs {
        $reflection = new \ReflectionMethod($class, $method);
        $docBlock = $reflection->getDocComment();

        $pairs = new KeyValuePairs();

        $lines = explode(PHP_EOL, $docBlock);
        // We do not require the `/**` and `*/`
        unset($lines[0]);
        unset($lines[count($lines)]);

        $cleanLines = [];
        foreach ($lines as $line) {
            $cleanLines[] = trim($line, ' *');
        }

        foreach ($cleanLines as $line) {
            if($line[0] == '@') {
                $keyValue = explode('=', substr($line, 1));
                if(count($keyValue) == 2) {
                    $pairs->create($keyValue[0], $keyValue[1]);
                }
            }
        }

        return $pairs;
    }
}