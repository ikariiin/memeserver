<?php
/**
 * Created by PhpStorm.
 * User: saitama
 * Date: 10/2/17
 * Time: 5:02 PM
 */

namespace memeserver\Core\Router;

use memeserver\Core\DataStructures\KeyValuePairs;
use memeserver\Core\Logging\Logger;
use memeserver\Core\Logging\LogMode;
use memeserver\Core\Parsers\DocBlock;

/**
 * Class Stock
 * @package memeserver\Core\Router
 */
abstract class Stock implements Router {
    /**
     * @var array
     */
    const INTERNAL_METHODS = [
        "route",
        "listMethods",
        "init",
        "formatUri",
        "updateRegexUri",
        "dispatch"
    ];

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var KeyValuePairs
     */
    private $routerStaticDetails;

    public function init(Logger $logger) {
        $this->routerStaticDetails = new KeyValuePairs();
        $this->logger = $logger;

        $methods = $this->listMethods();
        $parser = new DocBlock();

        foreach ($methods as $method) {
            $annotations = $parser->parse($this, $method);

            if(
                $annotations->isNull() ||
                !$annotations->isSet("RequestType") &&
                !$annotations->isSet("URI")
            ) {
                $this->logger->warn(
                    LogMode::LOG_DEVELOPMENT,
                    "Not including method `{$method}` in router as required annotations are not present"
                );
                continue;
            }

            $formattedUri = $this->formatUri($annotations->get("URI"));
            $rawUri = $annotations->get("URI");
            $regexUri = $formattedUri->getRegexUri();

            $this->routerStaticDetails
                ->create($regexUri,
                    (new KeyValuePairs())
                        ->create("requestType", $annotations->get("RequestType"))
                        ->create("uri", $formattedUri)
                        ->create("method", $method)
                );
        }
    }

    /**
     * @param string $method
     * @param string $uri
     */
    public function route(string $method, string $uri) {
        $rawRoutes = $this->routerStaticDetails->getInternalRawArray();

        foreach ($rawRoutes as $regexUri => $details) {
            if((bool) preg_match($regexUri, $uri, $matches) || $uri === $regexUri) {
                $this->dispatch($method, $details);
            }
        }
    }

    /**
     * @return array
     */
    protected function listMethods(): array {
        $methods = get_class_methods($this);
        foreach (static::INTERNAL_METHODS as $method) {
            unset($methods[array_search($method, $methods)]);
        }

        return $methods;
    }

    /**
     * @param string $uri
     * @return RegexBasedUri
     */
    protected function formatUri(string $uri): RegexBasedUri {
        if($uri == '/') {
            // SPECIAL CASE!!!oneoneone
            return new RegexBasedUri('/', '/', []);
        }

        $dynamics = [];
        $uri = str_replace('/', ';', $uri);
        $parts = explode(';', $uri);
        $regexUri = '/' . $uri . '/';

        // Iterate through the parts
        foreach ($parts as $part) {
            if(strlen($part) != 0) {
                // Find if it is a dynamic part
                if($part[0] == '{') {
                    preg_match('/[^\/]*/', $part, $matches);
                    $regexUri = $this->updateRegexUri($regexUri, $matches, $pattern = '[^\/]*');
                    $dynamics[] = substr($matches[0], 1, strlen($matches[0]) - 2);
                }
            }
        }

        $regexUri = str_replace(';', '\/', $regexUri);
        $uri = str_replace(';', '\/', $uri);

        return new RegexBasedUri($uri, $regexUri, $dynamics);
    }

    /**
     * @param string $regexUri
     * @param array $matches
     * @param string $pattern
     * @return string
     */
    private function updateRegexUri(string $regexUri, array $matches, string $pattern): string {
        $actualPortion = substr($regexUri, 1, strlen($regexUri) - 2);
        $newRegexStr = str_replace($matches[0], $pattern, $actualPortion);
        return '/' . $newRegexStr . '/';
    }

    private function dispatch(string $method, KeyValuePairs $details) {
    }
}