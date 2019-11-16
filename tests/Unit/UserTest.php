<?php

namespace Tests\Unit;

use Tests\DatabaseTestCase;

class UserTest extends DatabaseTestCase
{
    /** @test */
    public function aUserCanFetchTheirMostRecentReply()
    {
        $user = create('App\User');

        $reply = create('App\Reply', ['user_id' => $user->id]);

        $this->assertEquals($reply->id, $user->lastReply->id);
    }
}
