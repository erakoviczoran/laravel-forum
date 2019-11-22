<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\DatabaseTestCase;

class AddAvatarTest extends DatabaseTestCase
{
    /** @test */
    public function onlyMembersCanAddAvatars()
    {
        $this->withExceptionHandling();

        $this->json('post', route('api.avatar', 1))
            ->assertStatus(401);
    }

    /** @test **/
    public function aValidAvatarMustBeProvided()
    {
        $this->withExceptionHandling()->signIn();

        $this->json('post', route('api.avatar', auth()->id()), [
            'avatar' => 'not-an-image',
        ])->assertStatus(422);
    }

    /** @test **/
    public function aUserMayAddAnAvatarToTheirProfile()
    {
        $this->signIn();

        Storage::fake('public');

        $this->json('post', route('api.avatar', auth()->id()), [
            'avatar' => $file = UploadedFile::fake()->image('avatar.jpg'),
        ]);

        $this->assertEquals('avatars/' . $file->hashName(), auth()->user()->avatar_path);

        Storage::disk('public')->assertExists("avatars/" . $file->hashName());
    }
}
