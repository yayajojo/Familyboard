<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
   public function store(Request $request, Project $project)
   {
    $validatedData = $request->validate(
        ['body'=> 'required']
    );
    $project->tasks()->create($validatedData);
   }
}
