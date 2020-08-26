<?php

namespace App\Http\Controllers;

use App\Activity;
use App\Project;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function index()
    {
        
        $projects = Auth::user()->getProjects();
        return view('projects.index', ['projects' => $projects]);
    }

    public function show(Project $project)
    {
       $activities = $this->getActivities($project);

        $this->authorize('view', $project);
        return view('projects.show', [
            'project' => $project,
            'activities' => $activities
        ]);
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        //validate
        $validatedData = $this->validateRequest();

        //persisit
        $project = Auth::user()->projects()->save(new Project($validatedData));
        //redirect
        return redirect(route('project.show', compact('project')));
    }
    public function edit(Project $project)
    {
        return view('projects.edit', compact("project"));
    }
    public function update(Project $project)
    {
        $this->authorize('update', $project);
        $validatedData = $this->validateRequest();
        $project->update($validatedData);
        return redirect(route('project.show', compact('project')));
    }
    public function destory(Project $project)
    {
        $this->authorize('delete', $project);
        $project->delete();
        return redirect(route('project.index'));
    }
    protected function validateRequest()
    {
        return   request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'note' => 'nullable|max:1000'
        ]);
    }

    protected function getActivities(Project $project)
    {
        $taskActivityIds = $project->tasks->pluck('id');
        $totalActivities = DB::table('activities')
            ->where(function ($query) use ($project) {
                $query->where('recordable_type', '=', 'App\Project')
                    ->where('recordable_id', '=', $project->id);
            })
            ->orWhere(function ($query) use ($taskActivityIds) {
                $query->where('recordable_type', '=', 'App\Task')
                    ->whereIn('recordable_id', $taskActivityIds);
            })->get();

        $activities = Activity::whereIn('id', $totalActivities->pluck('id'))->orderBy('created_at', 'desc')->limit(8)->get();
        return $activities;
    }
}
