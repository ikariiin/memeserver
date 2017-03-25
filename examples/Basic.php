<?php
use memeserver\ThreadSafeIncluder;

include_once __DIR__ . '/../vendor/autoload.php';
include_once __DIR__ . '/BasicRouter.php';

(new ThreadSafeIncluder())
    ->include();

$settings = new \memeserver\Core\Settings();
$settings
    ->setListeningIp("0.0.0.0")
    ->setListeningPort(random_int(3000, 9999))
    ->setLogLevel(\memeserver\Core\Logging\LogMode::LOG_DEVELOPMENT)
    ->setLogDirectory(__DIR__ .'/../logs')
    ->setLogToConsole(true)
    ->setHandler((new \memeserver\Handler\Http()))
    ->setRouter((new BasicRouter()));

$initiator = new \memeserver\Initiator($settings);
$listener = $initiator->getListener();

if($listener->initListening()) {
    $listener->startWatcher();
}
