<?php

namespace Tests\Feature;

use Facade\FlareClient\Stacktrace\File;
use  Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /** @test */
    public function guest_can_not_manage_profiles()
    {
        $user = factory('App\User')->create();
        $this->get(route('profile.create'))->assertRedirect(route('login'));
        $this->post(route('profile.store'))->assertRedirect(route('login'));
    }

    /** @test */
    public function a_profile_can_store_its_avatar()
    {
        $user = factory('App\User')->create();
        $this->signIn($user);
        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->json('POST', '/profiles', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'avatar' => $file,
        ])->assertRedirect(route('project.index'));
       
        $this->assertDatabaseHas(
            'profiles',
            ['user_id' => $user->id]
        );
        Storage::disk('avatars')->assertExists($file->hashName());
        Storage::disk('avatars')->delete($file->hashName());
        
    }

    
    
    
}
