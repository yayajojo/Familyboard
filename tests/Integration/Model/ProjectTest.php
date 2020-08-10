<?php

namespace Tests\Integration\Model;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
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
}
