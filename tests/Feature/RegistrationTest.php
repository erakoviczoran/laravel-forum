<?php

namespace Tests\Feature;

use App\Mail\PleaseVerifyYourEmail;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use Tests\DatabaseTestCase;

class RegistrationTest extends DatabaseTestCase
{
    /** @test */
    public function aConfirmationThatEmailIsSentUponRegistration()
    {
        Mail::fake();

        event(new Registered(create('App\User')));

        Mail::assertSent(PleaseVerifyYourEmail::class);
    }

    /** @test */
    public function userCanVerifyTheirEmailAddresses()
    {
        Mail::fake();

        $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'foobarbaz',
            'password_confirmation' => 'foobarbaz',
        ]);

        $user = User::whereName('John Doe')->first();

        $this->assertFalse($user->verified);
        $this->assertNotNull($user->verification_token);

        $response = $this->get(route('register.verify', ['token' => $user->verification_token]));

        $response->assertRedirect(route('threads'));

        tap($user->fresh(), function ($user) {
            $this->assertTrue($user->verified);
            $this->assertNull($user->verification_token);
        });
    }

    /** @test */
    public function verifyingAnInvalidToken()
    {
        $this->get(route('register.verify', ['token' => 'invalid']))
             ->assertRedirect(route('threads'))
             ->assertSessionHas('flash', 'Unknown token.');
    }
}
