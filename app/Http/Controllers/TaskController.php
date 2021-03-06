<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function edit(Project $project,Task $task)
    {
        $this->isUserOwnerOrMemberOfProject($task);
        return view('tasks.edit',['task'=>$task,'project'=>$task->project]);
    }
    public function store(Project $project)
    {
        $this->authorize('update', $project);
        $validatedData = $this->validateRequest();
        $project->addTask($validatedData);
        return redirect(route('project.show', compact('project')));
    }

    public function update(Project $project, Task $task)
    {
        $this->isUserOwnerOrMemberOfProject($task);
        $validatedData = $this->validateRequest();
        $updatedAttribute = array_merge(
            $validatedData,
            [
                'completed' => request()->has('completed')
            ]
        );
        $task->update($updatedAttribute);
        return redirect()->action('ProjectController@show',['project'=>$project]);
    }

    protected function isUserOwnerOrMemberOfProject(Task $task)
    {
        if (
            Auth::user()->isNot($task->project->owner)
            && !$task->project->members->contains(Auth::user())
        ) {
            abort(403);
        }
    }

    protected function validateRequest()
    {
        return request()->validate(
            [
                'body' => 'required',
                'due' => 'required|date',
                'start' => 'required|date',
                'assignee_id'=>'required|int|exists:users,id'
            ]
        );
    }
}
