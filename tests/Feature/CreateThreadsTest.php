<?php

namespace Tests\Feature;

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
