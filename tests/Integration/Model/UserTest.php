<?php

namespace Tests\Integration\Model;

use Facades\Tests\SetUp\ProjectFactory;
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

    /** @test */
    public function a_user_has_getProjects_of_all_accessible_Projects()
    {
       [$may,$jhon,$kay] = factory('App\User',3)->create();
        $projectofMay = ProjectFactory::ownedBy($may)->create();
        $projectofMay->invite($jhon);
        $this->assertCount(1,$jhon->getProjects());
        $projectofKay= ProjectFactory::ownedBy($kay)->create();
        $projectofKay->invite($may);
        $this->assertCount(1,$jhon->getProjects());
        $projectofKay->invite($jhon);
        $this->assertCount(2,$jhon->getProjects());
    }
    
    
}
