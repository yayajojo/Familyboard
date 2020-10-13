<?php

namespace App\Http\Controllers;

use App\Events\ProjectInvitation;
use App\Events\UpdateProject;
use App\Http\Requests\InvitationRequest;
use App\Jobs\SendEmail;
use App\Mail\InvitationInformed;
use App\Project;
use App\User;
use Illuminate\Support\Facades\Mail;

class ProjectInvitationController extends Controller
{
    public function store(InvitationRequest $request, Project $project)
    {

        $validated = $request->validated();
        $invitedMember = User::whereEmail($validated['email'])->first();
        SendEmail::dispatch($invitedMember,$project);
        $project->invite($invitedMember);
        return redirect(route('project.show', compact('project')));
    }
}
