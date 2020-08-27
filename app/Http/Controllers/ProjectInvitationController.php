<?php

namespace App\Http\Controllers;

use App\Events\UpdateProject;
use App\Http\Requests\InvitationRequest;
use App\Project;
use App\User;
use Illuminate\Http\Request;

class ProjectInvitationController extends Controller
{
    public function store(InvitationRequest $request, Project $project)
    {

        $validated = $request->validated();
        $invitedMember = User::whereEmail($validated['email'])->first();
        $project->invite($invitedMember);
        return redirect(route('project.show', compact('project')));
    }
}
