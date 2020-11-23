# Memeserver

A multi-threaded server created for simple but fast responses. Is blazingly fast and has inbuilt error handling pages for HTTP error codes.

> Docs are in midst of creation through various magical spells.

A simple getting started script:

```
<?php
include_once __DIR__ . '/vendor/autoload.php';

use memeserver\ThreadSafeIncluder;

(new ThreadSafeIncluder())
    ->include();

use memeserver\Core\DataStructures\RouteData;

class OurVeryOwnRouter extends \memeserver\Core\Router\Stock {
    /**
     * @RequestType=GET
     * @URI=/
     * @param RouteData $data
     * @return \memeserver\Core\DataStructures\HttpResponse
     */
    public function index(RouteData $data) {
        $response = $data->getResponse();
        $response
            ->setBody('<h1>It works!</h1>')
            ->setStatus(200)
            ->setContentType('text/html');
        return $response;
    }
}

$settings = new \memeserver\Core\Settings();
$settings
    ->setListeningIp("0.0.0.0")
    ->setListeningPort(5600)
    ->setLogLevel(\memeserver\Core\Logging\LogMode::LOG_DEVELOPMENT)
    ->setLogDirectory(__DIR__ .'/../logs')
    ->setLogToConsole(true)
    ->setHandler((new \memeserver\Handler\Http()))
    ->setRouter((new OurVeryOwnRouter()));

$initiator = new \memeserver\Initiator($settings);
$listener = $initiator->getListener();
if($listener->initListening()) {
    $listener->startWatcher();
}
```

Fire up your browser, and open [localhost:5600](http://localhost:5600) and you should see something!

Or, if you do not want to go through all that pain...

```
$ composer require saitama-kun/memeserver
$ php vendor/saitama-kun/memeserver/examples/Basic.php
```

Just do that!
