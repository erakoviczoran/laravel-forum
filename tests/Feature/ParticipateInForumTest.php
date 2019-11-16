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

        $this->post(route('replies.store', [$thread->channel->id, $thread->id]));
    }

    /** @test */
    public function anAutheticatedUserMayParticipateInForumThreads()
    {
        $this->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply');

        $this->post(route('replies.store', [$thread->channel->id, $thread->id]), $reply->toArray());

        $this->assertDatabaseHas('replies', ['body' => $reply->body]);
    }

    /** @test */
    public function aReplyRequiresBody()
    {
        $this->withExceptionHandling()->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply', ['body' => null]);

        $this->json('post', route('replies.store', [$thread->channel->id, $thread->id]), $reply->toArray())
            ->assertStatus(422);
    }

    /** @test **/
    public function unauthorizedUserCanNotDeleteAReplies()
    {
        $this->withExceptionHandling();

        $reply = create('App\Reply');

        $this->delete(route('replies.delete', $reply))
            ->assertRedirect('/login');

        $this->signIn()
            ->delete(route('replies.delete', $reply))
            ->assertStatus(403);
    }

    /** @test **/
    public function authorizedUsersCanDeleteReplies()
    {
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $this->delete(route('replies.delete', $reply))->assertStatus(302);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    /** @test **/
    public function unauthorizedUserCanNotUpdateAReplies()
    {
        $this->withExceptionHandling();

        $reply = create('App\Reply');

        $this->patch(route('replies.update', $reply))
            ->assertRedirect('/login');

        $this->signIn()
            ->patch(route('replies.update', $reply))
            ->assertStatus(403);
    }

    /** @test **/
    public function authorizedUsersCanUpdateReplies()
    {
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $body = 'You updated body of reply.';

        $this->patch(route('replies.update', $reply), ['body' => $body]);

        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $body]);
    }

    /** @test **/
    public function repliesThatContainSpamMayNotBeCreated()
    {

        $this->withExceptionHandling()->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply', ['body' => 'Yahoo Customer Support']);

        $this->json('post', route('replies.store', [$thread->channel_id, $thread->id]), $reply->toArray())
            ->assertStatus(422);
    }

    /** @test **/
    public function aUsersMayOnlyReplyAMaximumOfOncePerMinute()
    {
        $this->withExceptionHandling()->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply', ['body' => 'Simple reply']);

        $this->post(route('replies.store', [$thread->channel_id, $thread->id]), $reply->toArray())
            ->assertStatus(201);

        $this->post(route('replies.store', [$thread->channel_id, $thread->id]), $reply->toArray())
            ->assertStatus(429);
    }
}
