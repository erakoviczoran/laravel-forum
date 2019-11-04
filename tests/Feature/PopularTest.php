<?php

namespace Tests\Feature;

use Exception;
use Tests\DatabaseTestCase;

class PopularTest extends DatabaseTestCase
{
    /** @test */
    public function aGuestCanNotFavoriteAnything()
    {
        $this->withExceptionHandling()
            ->post(route('replies.favorites', ['reply' => 1]))
            ->assertRedirect('/login');
    }

    /** @test */
    public function anAuthenticatedUserCanFavoriteAnyReply()
    {
        $this->signIn();

        $reply = create('App\Reply');

        $this->post(route('replies.favorites', ['reply' => $reply->id]));

        $this->assertCount(1, $reply->favorites);
    }

    /** @test */
    public function anAuthenticatedUserMayOnlyFavoriteAReplyOnce()
    {
        $this->signIn();

        $reply = create('App\Reply');

        try {
            $this->post(route('replies.favorites', ['reply' => $reply->id]));
            $this->post(route('replies.favorites', ['reply' => $reply->id]));
        } catch (Exception $e) {
            $this->fail('Did not expect to insert the same record set twice.');
        }

        $this->assertCount(1, $reply->favorites);
    }
}
