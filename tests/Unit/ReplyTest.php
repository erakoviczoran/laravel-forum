<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Tests\DatabaseTestCase;

class ReplyTest extends DatabaseTestCase
{
    /** @test */
    public function itHasAnUser()
    {
        $reply = create('App\Reply');

        $this->assertInstanceOf('App\User', $reply->user);
    }

    /** @test **/
    public function itKnowsIfItWasJustPublished()
    {
        $reply = create('App\Reply');

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subMonth();

        $this->assertFalse($reply->wasJustPublished());
    }

    /** @test **/
    public function itCanDetectAllMentionedUsersInABody()
    {
        $reply = create('App\Reply', [
            'body' => '@JaneDoe wants to talk to @JohnDoe',
        ]);

        $this->assertEquals(['JaneDoe', 'JohnDoe'], $reply->mentionedUsers());
    }
}
