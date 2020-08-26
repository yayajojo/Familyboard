<?php

namespace Tests\Feature;

use Facades\Tests\SetUp\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectInvitationTest extends TestCase
{
    /** @test */
    public function non_project_owner_can_not_invite()
    {
        $may = factory('App\User')->create();
        $project = ProjectFactory::ownedBy($may)->create();
        $jhon = $this->signIn();
        $this->post(route('invitation.store',compact('project')),['email'=>$jhon->email])->assertStatus(403);
    }
    
    /** @test */
    public function a_project_can_invit_a_member()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->create();
        $may = factory('App\User')->create();
        $this->post(route('invitation.store', compact('project')), ['email' => $may->email]);
        $this->assertTrue($project->members->contains($may));
    }

    /** @test */
    public function email_address_must_be_associated_with_a_valid_familyboard_account()
    {
        
        $project = ProjectFactory::ownedBy($this->signIn())->create();
        $notMemberEmail = 'notmember@email';
        $res = $this->post(route('invitation.store', compact('project')), ['email' => $notMemberEmail])
            ->assertSessionHasErrorsIn('invitation',['email'=>'The invited member should have a valid familyboard account']);
    }

    /** @test */
    public function a_project_can_invite_members()
    {
        $project = ProjectFactory::create();
        $member = factory('App\User')->create();
        $project->invite($member);
        $this->signIn($member);
        $this->patch(route('project.update',compact('project')),['title'=>'title changed'])->assertStatus(302);
        $this->assertDatabaseHas('projects',['title'=>'title changed']);
    }
}
