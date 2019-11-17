<?php

namespace App\Providers;

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

        collect($reply->mentionedUsers())->map(function ($name) {
            return User::whereName($name)->first();
        })->filter()->each(function ($user) use ($reply) {
            $user->notify(new YouWereMentioned($reply));
        });
    }
}
