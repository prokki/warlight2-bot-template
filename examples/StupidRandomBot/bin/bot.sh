#!/usr/bin/env php
<?php

include __DIR__ . '/../../../vendor/autoload.php';

/**
 * Initialize bot
 * __main__
 */
$bot = new \Prokki\Warlight2BotTemplate\Examples\StupidRandomBot\StupidRandomBot();

$client = new \Prokki\TheaigamesBotEngine\Client($bot);
$client->run();