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
        $this->authorize('view',$project);
    
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
        $validatedData = $this->validateRequest();
 
        //persisit
        $project = Auth::user()->projects()->save(new Project($validatedData));
        //redirect
        return redirect(route('project.show',compact('project')));
    }
    public function edit(Project $project)
    {
        return view('project.edit',compact("project"));
    }
    public function update(Project $project)
    {
        $this->authorize('update',$project);
        $validatedData = $this->validateRequest();
        $project->update($validatedData);
        return redirect(route('project.show',compact('project')));
    }

    protected function validateRequest()
    {
      return   request()->validate([
        'title' => 'sometimes|required',
        'description' => 'sometimes|required',
        'note'=>'nullable|max:1000'
    ]);
    }
}
