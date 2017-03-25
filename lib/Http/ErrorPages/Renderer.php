<?php

namespace memeserver\Http\ErrorPages;

/**
 * Class Renderer
 * @package memeserver\Http\ErrorPages
 */
class Renderer {
    /**
     * @var string
     */
    private $content;

    /**
     * Renderer constructor.
     * @param string $content
     * @param bool $debugRuntime
     */
    public function __construct(string $content, bool $debugRuntime) {
        $this->content = $content;
        if($debugRuntime) {
            $this->content = str_replace('%s-var{DEBUG_RUNTIME}', 'yes', $content);
        }
    }

    /**
     * @return string
     */
    public function getRenderedContent(): string {
        return $this->content;
    }
}