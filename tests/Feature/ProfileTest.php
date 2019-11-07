<?php

namespace Tests\Feature;

use Tests\DatabaseTestCase;

class ProfileTest extends DatabaseTestCase
{
    /** @test */
    public function aUserHasAProfile()
    {
        $user = create('App\User');

        $this->get(route('profiles.user', $user->id))
            ->assertSee($user->name);
    }

    /** @test */
    public function profilesDispalyAllThreadsCreatedByTheAssociatedUser()
    {
        $user = create('App\User');

        $thread = create('App\Thread', ['user_id' => $user->id]);

        $this->get(route('profiles.user', $user->id))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
