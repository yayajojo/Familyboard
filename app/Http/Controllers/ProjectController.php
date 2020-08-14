<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Auth::user()->getProjects();
        return view('project.index', ['projects' => $projects]);
    }

    public function show(Project $project)
    {
        if (Auth::user()->isNot($project->owner)) {
            abort(403);
        }
        return view('project.show', [
            'project' => $project
        ]);
    }

    public function create()
    {
        return view('project.create');
    }
    public function store(Request $request)
    {
        //validate
        $validatedData = $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        //persisit
        $project = Auth::user()->projects()->save(new Project($validatedData));
        //redirect
        return redirect(route('project.show',compact('project')));
    }
}
