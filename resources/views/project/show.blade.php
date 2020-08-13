@extends('layouts.nav')
@section('content')
<header class="flex items-end px-4 py-4 justify-between">
    <p class="text-sm text-gray-700">
        <a href="{{route('project.index')}}">
        My Projects
        </a>
        / {{$project->title}}</p>
    <form class="text-xl" action="{{route('project.create')}}" method="get">
        <button class="button-add" type="submit">
            Add Project
        </button>
    </form>
</header>
<main class="px-4 py-4">
    <div class="lg:flex -mx-3">
        <div class="w-3/4 px-3">
            <h2 class="text-lg text-gray font-normal">Tasks</h2>
            @forelse($project->tasks as $task)
            <p>{{$tsak->body}}</p>
            @empty
            <p>No tasks yet</p>
            @endforelse
            <h2 class="text-lg text-gray font-normal">General Notes</h2>
            <div class="card">Note content</div>
        </div>
        <div class="w-1/4">
            <x-card :project="$project"/>
        </div>
    </div>

</main>
@endsection