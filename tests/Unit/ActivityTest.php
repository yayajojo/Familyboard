<?php

namespace Tests\Unit;


use Tests\TestCase;
use Facades\Tests\SetUp\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function activity_has_a_user()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->create();
        $this->assertEquals(
            $project->activities->first()->user_id,
            Auth()->id()
        );
    }
}
