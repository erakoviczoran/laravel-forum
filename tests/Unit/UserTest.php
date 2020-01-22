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

    /** @test */
    public function aUserCanDetermineTheirAvatarPath()
    {
        $user = create('App\User');

        $this->assertEquals(asset('images/avatars/default.png'), $user->avatar_path);

        $user->avatar_path = 'avatars/me.jpeg';

        $this->assertEquals(asset('avatars/me.jpeg'), $user->avatar_path);
    }
}
