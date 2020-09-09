@extends('layouts.nav')

@section('content')

<form class="card w-1/3 mx-auto " enctype="multipart/form-data" method="post" action="{{route('profile.store')}}">
    <div class="flex flex-col">
        <h1 class="text-black text-lg">Edit Profile of {{$user->name}}</h1>
        @csrf
        <label class="mt-3" for="name">
            Name:
        </label>
        <input id="name" name="name" type="text" value="{{$user->name}}" required>
        <label class="mt-3" for="email">
            Email:
        </label>
        <input id="email" name="email" type="email" value="{{$user->email}}" required>
        <label class="mt-3" for="avatar">
            Avatar:
        </label>
        <input id="avatar" name="avatar" type="file">
        <label class="mt-3" for="password">
            Password:
        </label>
        <input id="password" name="password" type="password">
        <label class="mt-3" for="password_confirmation">
            Password Confirmation:
        </label>
        <input id="password_confirmation" name="password_confirmation" type="password">
    </div>
    <div class="flex items-end">
        <button class="button-add mt-3 w-1/4" type="submit">Submit</button>
        <a class="underline ml-10" href="{{route('project.index')}}">Cancel</a>
    </div>
</form>
@endsection