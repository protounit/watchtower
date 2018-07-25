# protounit/Watchtower
Telegram handler for Monolog. Send log info to channel with pretty formatting and useful information

![Telegram Channel Screenshot](https://image.ibb.co/fpFepT/Screenshot_20180726_013226.png  "protounit/watchtower")

*Inspired by* [monolog-telegram](https://github.com/moeinrahimi/monolog-telegram) 

## Dependencies
[monolog/monolog](https://github.com/Seldaek/monolog)
[guzzlehttp/guzzle](https://github.com/guzzle/guzzle) 

## How it works
* Watchtower handle Monolog methods to send messages
* After text formatting it creates fork of process and send message via guzzle
* Parent process doing nothing so you don't wait until it stops requesting Telegram API
* Child process waits for response and die after job is done

*Too much messages per time could eat all of your RAM because there is no fork bomb detectors!*

## Install
	composer require protounit/watchtower
	composer install
	
## Configuration
This array represents full amount of options you need to make package work

    $config = [
        'botId'     => 'BOTID:BOTID',
        'channelId' => 'CHANNELID',
        'timeZone'  => 'Europe/Rome',
    ];