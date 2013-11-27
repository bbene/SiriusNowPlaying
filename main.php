<?php
require_once('vendor/autoload.php');

$my_token = '';
$my_channel = 'dev';

$service = new \Bbene\SiriusNowPlaying($my_token, $my_channel);
$service->run();