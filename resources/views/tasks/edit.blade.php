@extends('layouts.nav')
@section('content')
<div class="mb-3 card w-1/2 mx-auto">
    <form class="flex flex-col" action="{{$task->path()}}" method="POST">
        @csrf
        {{ method_field('PATCH') }}
        <label class="my-3" for="body">Update Task</label>
        <input id="body" autocomplete="off" class="pl-2 w-full outline-none focus:shadow-outline" name="body" value="{{$task->body}}" required>
        <label class="my-3" for="start">Start Date:</label>
        <input class="mr-3" type="datetime-local" value="{{\Carbon\Carbon::parse($task->start)->format('Y-m-d\TH:i')}}" name="start" id="due" required>
        <label class="my-3" for="due">Due Date:</label>
        <input class="mr-3" type="datetime-local" value="{{\Carbon\Carbon::parse($task->due)->format('Y-m-d\TH:i')}}" name="due" id="due" required>
        <label class="my-3" for="completed">Completed:</label>
        <input class="mr-3" {{$task->completed?'checked':''}} type="checkbox" name="completed">
        <div>
            <label for="assignee_id">Assignees</label>
            <select name="assignee_id" id="assignee_id" required>
                @if($project->owner_id === $task->assignee_id)
                <option value="{{$project->owner_id}}" selected>{{$project->owner->name}}</option>
                @foreach($project->members as $member)
                <option value="{{$member->id}}">{{$member->name}}</option>
                @endforeach
                @else
                @foreach($project->members as $member)
                @if($member->id === $task->assignee_id)
                <option value="{{$member->id}}" selected>{{$member->name}}</option>
                @endif
                <option value="{{$member->id}}">{{$member->name}}</option>
                @endforeach
                <option value="{{$project->owner_id}}">{{$project->owner->name}}</option>
                @endif
            </select>
        </div>
        <div class="flex-col">
            <button class="button-add my-3 w-1/4" type="submit">Submit</button>
            <a class="underline ml-10" href="{{route('project.show',compact('project'))}}">Cancel</a>
        </div>
    </form>
</div>
@endsection