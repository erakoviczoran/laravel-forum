<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ThreadHasNewReply
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $thread;
    private $reply;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($thread, $reply)
    {
        $this->thread = $thread;
        $this->reply = $reply;
    }

    /**
     * Get create a new event instance.
     */
    public function getReply()
    {
        return $this->reply;
    }

    /**
     * Get create a new event instance.
     */
    public function getThread()
    {
        return $this->thread;
    }
}
