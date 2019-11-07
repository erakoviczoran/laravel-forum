<?php

namespace Tests\Feature;

use Tests\DatabaseTestCase;

class ParticipateInForumTest extends DatabaseTestCase
{
    /** @test */
    public function unauthenticatedUsersMayNotAddReplies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = create('App\Thread');

        $this->post(route('threads.replies', [$thread->channel->id, $thread->id]));
    }

    /** @test */
    public function anAutheticatedUserMayParticipateInForumThreads()
    {
        $this->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply');

        $this->post(route('threads.replies', [$thread->channel->id, $thread->id]), $reply->toArray());

        $this->get(route('threads.show', [$thread->channel->id, $thread->id]))
            ->assertSee($reply->body);
    }

    /** @test */
    public function aReplyRequiresBody()
    {
        $this->withExceptionHandling()->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply', ['body' => null]);

        $this->post(route('threads.replies', [$thread->channel->id, $thread->id]), $reply->toArray())
            ->assertSessionHasErrors('body');
    }
}
