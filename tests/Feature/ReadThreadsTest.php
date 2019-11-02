<?php

namespace Tests\Feature;

use Tests\DatabaseTestCase;

class ReadThreadsTest extends DatabaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->thread = create('App\Thread');
    }

    /** @test */
    public function aUserCanBrowseThreads()
    {
        $this->get(route('threads'))
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function aUserCanReadSingleThread()
    {
        $this->get(route('threads.show', [$this->thread->channel->id, $this->thread->id]))
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function aUserCanReadReplies()
    {
        $reply = create('App\Reply', ['thread_id' => $this->thread->id]);

        $this->get(route('threads.show', [$this->thread->channel->id, $this->thread->id]))
            ->assertSee($reply->body);
    }

    /** @test */
    public function aUserCanFilterThreadsAccordingToATag()
    {
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');

        $this->get('/threads/' . $channel->id)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /** @test */
    public function aUserCanFilterThreadsByAnyUsername()
    {
        $this->signIn();

        $threadByLoggedUser = create('App\Thread', ['user_id' => auth()->id()]);
        $threadByGuest = create('App\Thread');

        $this->get(route('threads', ['by' => auth()->user()->name]))
            ->assertSee($threadByLoggedUser->title)
            ->assertDontSee($threadByGuest->title);
    }
}
