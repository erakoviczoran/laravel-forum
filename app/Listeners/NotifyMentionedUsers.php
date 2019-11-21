<?php

namespace App\Listeners;

use App\Events\ThreadHasNewReply;
use App\Notifications\YouWereMentioned;
use App\User;

class NotifyMentionedUsers
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ThreadHasNewReply  $event
     * @return void
     */
    public function handle(ThreadHasNewReply $event)
    {
        $reply = $event->getReply();

        User::whereIn('name', $reply->mentionedUsers())
            ->get()
            ->each(function ($user) use ($reply) {
                $user->notify(new YouWereMentioned($reply));
            });
    }
}
