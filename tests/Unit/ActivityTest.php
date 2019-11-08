<?php

namespace Tests\Unit;

use App\Activity;
use Carbon\Carbon;
use Tests\DatabaseTestCase;

class ActivityTest extends DatabaseTestCase
{
    /** @test */
    public function itRecordsActivityWhenAThreadIsCreated()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => 'App\Thread',
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    /** @test */
    public function itRecordsActivityWhenAReplyIsCreated()
    {
        $this->signIn();

        $reply = create('App\Reply');

        $this->assertEquals(2, Activity::count());
    }

    /** @test **/
    public function itFetchedAFeedForAnyUser()
    {
        $this->signIn();
        create('App\Thread', ['user_id' => auth()->id()]);

        create('App\Thread', [
            'user_id' => auth()->id(),
            'created_at' => Carbon::now()->subWeek(),
        ]);

        $feed = Activity::feed(auth()->user());

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));
    }
}
