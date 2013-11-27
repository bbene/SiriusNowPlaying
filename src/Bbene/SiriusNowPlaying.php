<?php

namespace Bbene;

class SiriusNowPlaying
{
    protected $hipchat_room;
    protected $hc;
    protected $reader;
    protected $current_playing;

    public function __construct($hipchat_token, $hipchat_room)
    {
        date_default_timezone_set('UTC');
        $this->hipchat_room = $hipchat_room;
        $this->hc = new \HipChat\HipChat($hipchat_token);
        $this->reader = new \Sabre\XML\Reader();
        $this->current_playing = '';
    }

    public function get_now_playing()
    {
        return $this->current_playing;
    }

    /**
     * Daemon.  Updates every 30 seconds.
     */
    public function run()
    {
        while(1)
        {
            $currentTime = date('m-d-G:i:00');
            $this->reader->open('http://www.siriusxm.com/metadata/pdt/en-us/xml/channels/hardattack/timestamp/'.$currentTime);
            $output = $this->reader->parse();

            $song_title = $output['value'][2]['value'][3]['value'][6]['value'][15]['value'];
            $song_artist = $output['value'][2]['value'][3]['value'][0]['value'][1]['value'];
            $now_playing = "Now Playing: $song_title by $song_artist";

            if($this->current_playing == $now_playing)
            {
                // Song hasn't changed.  Do nothing.  Log cycle.
                echo '.';
            }
            else
            {
                echo PHP_EOL;
                // New song.  Update current_playing and send alert.
                $this->current_playing = $now_playing;
                //$this->hc->message_room($this->hipchat_room, 'SiriusXM', $this->current_playing);
                echo $this->current_playing . PHP_EOL;
            }

            sleep(30);
        }
    }
}