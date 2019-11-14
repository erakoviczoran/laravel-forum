<?php

namespace Tests\Unit;

use App\Notifications\ThreadWasUpdated;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Notification;
use Tests\DatabaseTestCase;

class ThreadTest extends DatabaseTestCase
{
    protected $thread;

    public function setUp(): void
    {
        parent::setUp();

        $this->thread = create('App\Thread');
    }

    /** @test */
    public function aThreadHasCreator()
    {
        $this->assertInstanceOf(User::class, $this->thread->user);
    }

    /** @test */
    public function aThreadHasReplies()
    {
        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }

    /** @test */
    public function aThreadCanAddAReply()
    {
        $this->thread->addReply([
            'body' => 'foobar',
            'user_id' => 1,
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /** @test **/
    public function aThreadNotifiesAllRegisteredSubscribersWhenANewReplyIsAdded()
    {
        Notification::fake();

        $this->signIn();

        $this->thread->subscribe()
            ->addReply([
                'body' => 'foobar',
                'user_id' => create('App\User')->id,
            ]);

        Notification::assertSentTo(auth()->user(), ThreadWasUpdated::class);
    }

    /** @test */
    public function aThreadBelongsToAChannel()
    {
        $thread = create('App\Thread');

        $this->assertInstanceOf('App\Channel', $thread->channel);
    }

    /** @test **/
    public function aThreadCanBeSubscribedTo()
    {
        $thread = create('App\Thread');

        $thread->subscribe($userId = 1);

        $this->assertEquals(1, $thread->subscriptions()->where('user_id', $userId)->count());
    }

    /** @test **/
    public function aThreadCanBeUnsubscribedFrom()
    {
        $thread = create('App\Thread');

        $thread->subscribe($userId = 1);

        $thread->unsubscribe($userId);

        $this->assertCount(0, $thread->subscriptions);
    }

    /** @test **/
    public function itKnowsIfAuthenticatedUserIsSubscribed()
    {
        $thread = create('App\Thread');

        $this->signIn();

        $this->assertFalse($thread->isSubscribed);

        $thread->subscribe();

        $this->assertTrue($thread->isSubscribed);
    }

    /** @test **/
    public function aThreadCanCheckIfAuthenticatedUserHasReadAllReplies()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $user = auth()->user();

        $this->assertTrue($thread->hasUpdatesForLoggedUser());

        $user->read($thread);

        $this->assertFalse($thread->hasUpdatesForLoggedUser());
    }
}
