@extends('layouts.nav')
@section('content')

<x-form-component :project="$project">
    <x-slot name="title">
        Edit your project
    </x-slot>
    <x-slot name="form_title">
        <form action="{{route('project.update',compact('project'))}}" method="post">
            @method('PATCH')
    </x-slot>
    <x-slot name="submit">
        <button class="button-add mr-8 " type="submit">
            Update Project
        </button>
        <a class="underline" href="{{route('project.show',compact('project'))}}">Cancel</a>
    </x-slot>
</x-form-component>
@endsection