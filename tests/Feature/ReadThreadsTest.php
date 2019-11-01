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
}
