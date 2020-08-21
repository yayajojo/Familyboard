@extends('layouts.nav')
@section('content')
<x-form-component :project='new App\Project'>
    <x-slot name="title">
        Create your project
    </x-slot>
    <x-slot name="form_title">
        <form action="{{route('project.store')}}" method="post">
    </x-slot>
    <x-slot name="submit">
        <button class="button-add mr-8 " type="submit">
            Create Project
        </button>
        <a class="underline" href="{{route('project.index')}}">Cancel</a>
    </x-slot>
</x-form-component>
@endsection