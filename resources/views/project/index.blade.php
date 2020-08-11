@extends('layouts.app')
@section('content')
    <ul>
        @forelse($projects as $project)
        <li class="bg-red">
            <a href="{{route('project.show',$project)}}"> 
                {{$project->title}}
            </a>
        </li>
        @empty
        <li>No project yet!</li>
        @endforelse
    </ul>
@endsection