<?php

namespace Tests\Unit;

use Tests\DatabaseTestCase;

class ReplyTest extends DatabaseTestCase
{
    /** @test */
    public function itHasAnOwner()
    {
        $reply = create('App\Reply');

        $this->assertInstanceOf('App\User', $reply->owner);
    }
}
