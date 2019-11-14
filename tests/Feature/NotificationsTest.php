<?php

namespace Tests\Feature;

use Illuminate\Notifications\DatabaseNotification;
use Tests\DatabaseTestCase;

class NotificationsTest extends DatabaseTestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->signIn();
    }

    /** @test */
    public function aNotificationIsPreparedWhenASubscribedThreadReceivesANewReplyThatIsNotByTheCurrentUser()
    {
        $thread = create('App\Thread')->subscribe();

        $this->assertCount(0, auth()->user()->notifications);

        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'Some reply',
        ]);

        // a notification should be prepared for the user
        $this->assertCount(0, auth()->user()->fresh()->notifications);

        $thread->addReply([
            'user_id' => create('App\User')->id,
            'body' => 'Some reply',
        ]);

        // a notification should be prepared for the user
        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }

    /** @test **/
    public function aUserCanFetchTheirUnreadNotifications()
    {
        create(DatabaseNotification::class);

        $this->assertCount(
            1,
            $this->getJson(route('userNotifications', auth()->user()))->json()
        );
    }

    /** @test **/
    public function aUserCanMarkANotificationAsRead()
    {
        create(DatabaseNotification::class);

        tap(auth()->user(), function ($user) {
            $this->assertCount(1, $user->unreadNotifications);

            $this->delete(route('userNotifications.delete', [
                $user,
                $user->unreadNotifications->first()->id,
            ]));

            $this->assertCount(0, $user->fresh()->unreadNotifications);
        });
    }
}
