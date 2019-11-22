<?php

namespace Tests\Unit;

use App\User;
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

    /** @test **/
    public function itWrapsMentionedUsersInTheBodyWithinAnchorTags()
    {
        create('App\User', ['name' => 'JaneDoe']);
        create('App\User', ['name' => 'Frank-Doe']);

        $reply = create('App\Reply', [
            'body' => 'Hello @JaneDoe and @Frank-Doe.',
        ]);

        $this->assertEquals(
            'Hello <a href="/profiles/' . User::whereName('JaneDoe')->first()->id . '">@JaneDoe</a>' .
            ' and <a href="/profiles/' . User::whereName('Frank-Doe')->first()->id . '">@Frank-Doe</a>.',
            $reply->body
        );
    }
}
