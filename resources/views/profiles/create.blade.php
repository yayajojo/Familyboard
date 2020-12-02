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
        @error('name')
        <span role="alert">
            <p class="mt-4 text-red-600">{{ $message }}</p>
        </span>
        @enderror
        <label class="mt-3" for="email">
            Email:
        </label>
        <input id="email" name="email" type="email" value="{{$user->email}}" required>
        @error('email')
        <span role="alert">
            <p class="mt-4 text-red-600">{{ $message }}</p>
        </span>
        @enderror
        <label class="mt-3" for="avatar">
            Avatar:
        </label>
        <input id="avatar" name="avatar" type="file">
        <label class="mt-3" for="password">
            Password:
        </label>
        <input id="password" name="password" type="password" required>
        @error('password')
        <span role="alert">
            <p class="mt-4 text-red-600">{{ $message }}</p>
        </span>
        @enderror
        <label class="mt-3" for="password_confirmation">
            Password Confirmation:
        </label>
        <input id="password_confirmation" name="password_confirmation" type="password" required>
        @error('password_confirmation')
        <span role="alert">
            <p class="mt-4 text-red-600">{{ $message }}</p>
        </span>
        @enderror
    </div>
    <div class="flex items-end">
        <button class="button-add mt-3 w-1/4" type="submit">Submit</button>
        <a class="underline ml-10" href="{{route('project.index')}}">Cancel</a>
    </div>
</form>
@endsection