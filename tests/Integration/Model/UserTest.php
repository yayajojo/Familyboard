<?php

namespace Tests\Integration\Model;

use Illuminate\Database\Eloquent\Collection as Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase,WithFaker;
    /** 
     * @test 
     * 
     */
    public function a_user_has_Projects()
    {
        $user = factory('App\User')->create();
        $this->assertInstanceOf(Collection::class,$user->projects);
    }
    
}
