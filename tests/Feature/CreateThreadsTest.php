<?php

namespace Tests\Feature;

use App\Activity;
use Tests\DatabaseTestCase;

class CreateThreadsTest extends DatabaseTestCase
{
    /** @test */
    public function guestMayNotCreateThreads()
    {
        $this->withExceptionHandling();

        $this->get(route('threads.create'))
             ->assertRedirect('/login');

        $this->post(route('threads'))
             ->assertRedirect('/login');
    }

    /** @test */
    public function guestsCannotSeeTheCreateThreadPage()
    {
        $this->withExceptionHandling();

        $this->get(route('threads.create'))->assertRedirect('/login');
    }

    /** @test */
    public function authenticatedUsersMustFirstConfirmTheirEmailAdressBeforeCreatingThreads()
    {
        $this->publishThread()
             ->assertRedirect('/threads')
             ->assertSessionHas('flash', 'You must first confirm your email address.');
    }

    /** @test */
    public function anAuthenticatedUserCanCreateNewForumThread()
    {
        // signed in user
        $this->signIn();

        // when we hit the endpoint to create thread
        $thread = make('App\Thread');
        $response = $this->post(route('threads.store'), $thread->toArray());

        // when we visit thread page check that we see new thread
        $this->get($response->headers->get('Location'))
             ->assertSee($thread->title)
             ->assertSee($thread->body);
    }

    /** @test */
    public function aThreadRequiresATitle()
    {
        $this->publishThread(['title' => null])
             ->assertSessionHasErrors('title');
    }

    /** @test */
    public function aThreadRequiresABody()
    {
        $this->publishThread(['body' => null])
             ->assertSessionHasErrors('body');
    }

    /** @test */
    public function unauthorizedUsersCanNotDeleteThreads()
    {
        $this->withExceptionHandling();

        $thread = create('App\Thread');

        $this->delete(route('threads.delete', [
            'channel' => $thread->channel->id,
            'thread' => $thread->id,
        ]))->assertRedirect('/login');

        $this->signIn();

        $this->delete(route('threads.delete', [
            'channel' => $thread->channel->id,
            'thread' => $thread->id,
        ]))->assertStatus(403);
    }

    /** @test */
    public function authorizedUsersCanDeleteThreads()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $this->json('DELETE', route('threads.delete', [$thread->channel, $thread]))
             ->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

        $this->assertEquals(0, Activity::count());
    }

    /** @test */
    public function aThreadRequiresAValidChannel()
    {
        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id' => null])
             ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
             ->assertSessionHasErrors('channel_id');
    }

    public function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();

        $thread = make('App\Thread', $overrides);

        return $this->post(route('threads.store'), $thread->toArray());
    }
}
