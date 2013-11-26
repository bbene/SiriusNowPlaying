<?php
require_once('vendor/autoload.php');
date_default_timezone_set('UTC');

/*
 * CONFIG
 */
$hipchat_token = '';
$hipchat_room = '';

/*
 * Init
 */
$hc = new \HipChat\HipChat($hipchat_token);
$reader = new \Sabre\XML\Reader();
$current_playing = '';

/*
 * Daemon.  Updates every 30 seconds.
 */
while(1)
{
    $currentTime = date('m-d-G:i:00');
    $reader->open('http://www.siriusxm.com/metadata/pdt/en-us/xml/channels/hardattack/timestamp/'.$currentTime);
    $output = $reader->parse();

    $song_title = $output['value'][2]['value'][3]['value'][6]['value'][15]['value'];
    $song_artist = $output['value'][2]['value'][3]['value'][0]['value'][1]['value'];
    $now_playing = "Now Playing: $song_title by $song_artist";

    if($current_playing == $now_playing)
    {
        // Song hasn't changed.  Do nothing.  Log cycle.
        echo '.';
    } else
    {
        echo PHP_EOL;
        // New song.  Update current_playing and send alert.
        $current_playing = $now_playing;
        $hc->message_room($hipchat_room, 'SiriusXM', $current_playing);
        echo $current_playing . PHP_EOL;
    }

    sleep(30);
}
