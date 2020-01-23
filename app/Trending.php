<?php

namespace App;

use Illuminate\Support\Facades\Redis;

class Trending
{
    private $key = 'trending-threads';

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    public function get()
    {
        return $trending = array_map('json_decode', Redis::zrevrange($this->getKey(), 0, 4));
    }

    public function push(Thread $thread)
    {
        return Redis::zincrby($this->getKey(), 1, json_encode([
            'path' => route('threads.show', [$thread->channel_id, $thread->id]),
            'title' => $thread->title,
        ]));
    }

    public function reset()
    {
        Redis::del($this->getKey());
    }
}
