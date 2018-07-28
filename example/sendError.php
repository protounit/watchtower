<?php
require __DIR__ . '/../vendor/autoload.php';

use Monolog\Logger;
use Protounit\WatchTower\TelegramHandler;

/**
 * Minimal required configuration
 */
$config = [
    'botId'     => 'BOTID:BOTID',
    'channelId' => 'CHANNELID',
    'timeZone'  => 'Europe/Rome',
    'useFork'   => true,
];

/**
 * Creating Logger interface with custom channel name
 */
$logger = new Logger('WatchTower');

/**
 * Including custom handler for Monolog messages
 */
$logger->pushHandler(new TelegramHandler($config));

/**
 * Example messages
 */
$logger->error(
    'An error occurred while creating another better example',
    [
        'file'      => __FILE__,
        'line'      => __LINE__,
        'debugInfo' => [
            'message' => 'Yet another message',
        ],
    ]
);

/**
 * Something more interesting
 */
$logger->critical(
    'Cannot allocate memory: couldn\'t create child process',
    [
        'file'      => __FILE__,
        'line'      => __LINE__,
        'debugInfo' => [
            'memory' => '640K',
        ],
    ]
);