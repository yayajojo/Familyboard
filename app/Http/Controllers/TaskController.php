<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function store(Request $request, Project $project)
    {
        $this->authorize('update', $project);
        $validatedData = $request->validate(
            ['body' => 'required']
        );
        $project->addTask($validatedData);

        return redirect(route('project.show', $project));
    }

    public function update(Project $project, Task $task)
    {
        $this->userIsOwnerOrMemberOfProject($task);
        request()->validate(['body' => 'required']);
        $updatedAttribute = [
            'body' => request('body'),
            'completed' => request()->has('completed')
        ];
        $task->update($updatedAttribute);
        return redirect(route('project.show', compact('project')));
    }

    protected function userIsOwnerOrMemberOfProject(Task $task)
    {
        if (
            Auth::user()->isNot($task->project->owner)
            && !$task->project->members->contains(Auth::user())
        ) {
            abort(403);
        }
    }
}
