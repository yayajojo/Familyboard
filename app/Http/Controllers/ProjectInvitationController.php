<?php

namespace App\Http\Controllers;

use App\Events\ProjectInvitation;
use App\Events\UpdateProject;
use App\Http\Requests\InvitationRequest;
use App\Mail\InvitationInformed;
use App\Project;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProjectInvitationController extends Controller
{
    public function store(InvitationRequest $request, Project $project)
    {

        $validated = $request->validated();
        $invitedMember = User::whereEmail($validated['email'])->first();
        Mail::to($invitedMember->email)->send(new InvitationInformed($invitedMember,$project));
        broadcast(new ProjectInvitation($invitedMember));
        $project->invite($invitedMember);
        return redirect(route('project.show', compact('project')));
    }
}
