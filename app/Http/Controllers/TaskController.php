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
        if (Auth::user()->isNot($project->owner)) {
            abort(403);
        }
        $validatedData = $request->validate(
            ['body' => 'required']
        );
        $project->addTask($validatedData);

        return redirect(route('project.show', $project));
    }

    public function update(Project $project,Task $task)
    {
         if (Auth::user()->isNot($task->project->owner)
        
        ) {
            abort(403);
        }

        request()->validate(['body' => 'required']);
        $updatedAttribute = [
            'body' => request('body'),
            'completed' => request()->has('completed')
        ];
        $task->update($updatedAttribute);
        return redirect(route('project.show',compact('project')));
    }
}
