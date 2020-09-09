<?php

namespace Tests\Feature;

use Facade\FlareClient\Stacktrace\File;
use GuzzleHttp\Psr7\UploadedFile;
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
        Storage::fake('app/public/avatars');
        
        $response = $this->json('POST', '/profiles', [
            'avatar' => new File(storage_path('tests/robot.png'))
        ]);

        // Assert the file was stored...
        Storage::disk('app/public/avatars')->assertExists('robot.png');

        $this->post(
            route('profile.store'),
            [
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $this->faker->image('tests'),
                'password' => '12345678',
                'password_confirmation' => '12345678',
            ]
        );

        $this->assertDatabaseHas(
            'profiles',
            ['user_id' => $user->id]
        );
    }
}
