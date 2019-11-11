<?php

namespace Tests\Feature;

use Tests\DatabaseTestCase;

class ProfileTest extends DatabaseTestCase
{
    /** @test */
    public function aUserHasAProfile()
    {
        $this->signIn();

        $this->get(route('profiles.user', auth()->user()))
            ->assertSee(auth()->user()->name);
    }

    /** @test */
    public function profilesDispalyAllThreadsCreatedByTheAssociatedUser()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $this->get(route('profiles.user', auth()->user()))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
