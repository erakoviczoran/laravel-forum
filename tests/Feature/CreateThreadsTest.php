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
        $this->post('/threads', $thread->toArray());

        // when we visit thread page check that we see new thread
        $thread = create('App\Thread');
        $this->get(route('threads.show', [$thread->channel->id, $thread->id]))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
