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
    public function aUserCanFilterThreadsAccordingToATag()
    {
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread', ['channel_id' => $channel->id]);
        $threadNotInChannel = create('App\Thread');

        $this->get(route('threads.channels', $channel->id))
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

    /** @test */
    public function aUserCanFilterThreadByPopularity()
    {
        $threadWithTwoReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithThreeReplies->id], 3);

        $threadWithNoReplies = $this->thread;

        $response = $this->getJson(route('threads', ['popular' => 1]))->json();

        $this->assertEquals([3, 2, 0], array_column($response['data'], 'replies_count'));
    }

    /** @test **/
    public function aUserCanFilterThreadsByThoseThadAreUnanswered()
    {
        $thread = create('App\Thread');
        create('App\Reply', ['thread_id' => $thread->id]);

        $response = $this->getJson(route('threads', ['unanswered' => 1]))->json();

        $this->assertCount(1, $response['data']);
    }

    /** @test **/
    public function aUserCanRequestAllRepliesForAGivenThread()
    {
        $thread = create('App\Thread');
        create('App\Reply', ['thread_id' => $thread->id], 2);

        $response = $this->getJson(route('replies', [$thread->channel_id, $thread->id]))->json();

        $this->assertCount(2, $response['data']);
        $this->assertEquals(2, $response['total']);
    }
}
