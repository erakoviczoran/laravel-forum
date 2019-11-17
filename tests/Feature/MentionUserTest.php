<?php

namespace Tests\Feature;

use Tests\DatabaseTestCase;

class MentionUserTest extends DatabaseTestCase
{
    /** @test */
    public function mentionedUsersInAReplyAreNotified()
    {
        $john = create('App\User', ['name' => 'JohnDoe']);
        $this->signIn($john);

        $jane = create('App\User', ['name' => 'JaneDoe']);
        $thread = create('App\Thread');

        $reply = create('App\Reply', [
            'body' => '@JaneDoe look at this, you too @FrankDoe',
        ]);

        $this->json('post', route('replies.store', [$thread->channel->id, $thread->id]), $reply->toArray());

        $this->assertCount(1, $jane->notifications);
    }
}
