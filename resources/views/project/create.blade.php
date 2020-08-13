@extends('layouts.nav')
@section('content')
<h1>Create a Project</h1>
<form class="container" action="{{route('project.store')}}" method="post">
    @csrf
    <div class="field">
        <label for="title" class="label">Title</label>
        <div class="control">
            <input class="input" type="text" name="title" id="title">
        </div>
    </div>
    <div class="field">
        <label for="description" class="label">Description</label>
        <div class="control">
            <textarea class="" name="description" id="description" cols="30" rows="10"></textarea>
        </div>
    </div>
    <div class="field">
        <div class="control">
            <button type="submit">
                Create Project
            </button>
            <a href="{{route('project.index')}}">Cancel</a>
        </div>
    </div>
</form>
@endsection