<?php
require_once('vendor/autoload.php');
require_once('class/SiriusNowPlaying.php');

$my_token = '';
$my_channel = 'dev';

$service = new SiriusNowPlaying($my_token, $my_channel);
$service->run();