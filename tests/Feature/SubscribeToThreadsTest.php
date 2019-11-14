<?php

namespace Tests\Feature;

use Tests\DatabaseTestCase;

class SubscribeToThreadsTest extends DatabaseTestCase
{
    /** @test */
    public function aUserCanSubscribeToThreads()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->post(route('threadSubscriptions.store', [$thread->channel, $thread]));

        $this->assertCount(1, $thread->fresh()->subscriptions);
    }

    /** @test **/
    public function aUserCanUnsubscribeToThreads()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $thread->subscribe();

        $this->delete(route('threadSubscriptions.delete', [$thread->channel_id, $thread->id]));

        $this->assertCount(0, $thread->subscriptions);
    }
}
