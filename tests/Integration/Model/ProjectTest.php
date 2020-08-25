<?php

namespace Tests\Integration\Model;

use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @test
     */
    public function a_project_belongs_to_an_owner()
    {
     $project = factory('App\Project')->create();
     $this->assertInstanceOf('App\User',$project->owner);
    }
    /** @test */
    public function project_can_add_a_task()
    {
        $project = factory('App\Project')->create();
        
        $project->addTask(['body'=>'Test task']);
        $this->assertDatabaseHas('tasks',
        ['project_id'=>$project->id,
         'body'=>'Test task'
        ]);
        $this->assertCount(1,$project->tasks);
    }
    /** @test */
    public function a_project_can_invite_a_member()
    {
        $project = ProjectFactory::create();
        $member =factory('App\User')->create();
        $project->invite($member);
        $this->assertTrue($project->members->contains($member));
    } 
    
}
