<?php

namespace Tests\Feature;

use App\Trending;
use Tests\DatabaseTestCase;

class TrendingThreadsTest extends DatabaseTestCase
{

    public function setUp(): void
    {
        parent::setUp();

        $this->trending = new Trending();

        $this->trending->reset();
    }

    /** @test */
    public function itIncrementsAThreadsScoreEachTimeItIsRead()
    {
        $this->assertEmpty($this->trending->get());

        $channel = create('App\Channel');
        $thread = create('App\Thread', ['channel_id' => $channel->id]);

        $this->call('GET', route('threads.show', [$thread->channel_id, $thread]));

        $this::assertCount(1, $trending = $this->trending->get());

        $this->assertEquals($thread->title, ($trending[0])->title);
    }
}
