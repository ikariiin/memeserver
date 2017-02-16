<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 12/2/17
 * Time: 4:36 PM
 */

namespace memeserver;

class ThreadSafeIncluder {
    /**
     * @return void
     */
    public function include(): void {
        $files = $this->listFiles();
        foreach ($files as $file) {
            $file = $file[0];
            include_once $file;
        }
    }

    /**
     * @param string $dir
     * @return \RegexIterator
     */
    private function listFiles(string $dir = __DIR__): \RegexIterator {
        return new \RegexIterator(
            (new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($dir),
                \RecursiveIteratorIterator::SELF_FIRST)
            ),
            '/^.+\.php$/i',
            \RecursiveRegexIterator::GET_MATCH
        );
    }
}