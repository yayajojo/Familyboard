@extends('layouts.nav')
@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<div id="projectshow">
    <header class="flex items-end px-4 py-4 justify-between">
        <p class="text-sm text-gray-700">
            <a href="{{route('project.index')}}">
                My Projects
            </a>
            / {{$project->title}}</p>
        <div class="flex items-center">
            <x-gravartar :project="$project" />
            <form class="text-xl" action="{{route('project.edit',compact('project'))}}" method="get">
                <button class="button-add" type="submit">
                    Edit Project
                </button>
            </form>
        </div>
    </header>
    <main class="px-4 py-4">
        <div class="lg:flex -mx-3">
            <div class="w-3/4 px-3">
                <h2 class="text-xl my-3 text-gray-700 font-normal">Tasks</h2>
                @foreach($project->tasks as $task)
                <x-task :task="$task" />
                @endforeach
                <div class="card mb-3">
                    <form action="{{route('task.store',compact('project'))}}" method="post">
                        @csrf
                        <input value="" autocomplete="off" class="pl-2 w-full outline-none focus:shadow-outline" name="body" placeholder="Begin adding tasks...">
                    </form>
                </div>

                <h2 class="text-xl my-3 text-gray-700 font-normal">General Notes</h2>
                <div>
                    <form class="card flex-column" action="{{route('project.update',compact('project'))}}" method="post">
                        @csrf
                        @method('PATCH')
                        <textarea class="pl-2 w-full text-left" placeholder="Add some notes..." name="note" id="note" rows="5"> {{$project->note}}</textarea>
                        <button class="button-add m-2" type="submit">save</button>
                    </form>
                </div>
            </div>
            <div class="w-1/4 m-4">
                <x-card :project="$project" />
                @include('activities.index',['project'=>$project])
                @can('invite',$project)
                <x-invitation :project="$project" />
                @endcan

            </div>

        </div>
    </main>
</div>
@endsection