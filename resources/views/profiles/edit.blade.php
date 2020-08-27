@extends('layouts.app')

@section('content')
<h1 class="text-2xl text-center text-black font-bold">Edit Profile of {{$user->name}}</h1>

<form enctype="multipart/form-data" method="post" action="{{route('profiles.update',$profile)}}" >
    @csrf
    {{ method_field('patch') }}
    <label class="my-4 text-xl text-left text-black font-bold" 
    for="username">
        Username
    </label>
    <input class="my-4 w-full resize-y border rounded focus:outline-none focus:shadow-outline" 
    id="username"
    name="username"
    type="text"
    value="{{$user->username}}"
    required>
    <label class="my-4 text-xl text-left text-black font-bold" 
    for="name">
        Name
    </label>
    <input class="my-4 w-full resize-y border rounded focus:outline-none focus:shadow-outline" 
    id="name"
    name="name"
    type="text"
    value="{{$user->name}}"
    required>
    <label class="my-4 text-xl text-left text-black font-bold" 
    for="email">
    Email
    </label>
    <input class="my-4 w-full resize-y border rounded focus:outline-none focus:shadow-outline" 
    id="email"
    name="email"
    type="email"
    value="{{$user->email}}"
    required>
    <label class="my-4 text-xl text-left text-black font-bold" 
    for="avatar">
    Avatar
    </label>
    <input class="my-4 w-full resize-y border rounded focus:outline-none focus:shadow-outline" 
    id="avatar"
    name="avatar"
    type="file"
   >
    <label class="my-4 text-xl text-left text-black font-bold" for="body">
        Self Introduction
    </label>
    <textarea class="my-4 w-full resize-y border rounded focus:outline-none focus:shadow-outline" 
    name="body" 
    id="body"
    required>
    {{$profile->body}}
   </textarea>
   <label class="my-4 text-xl text-left text-black font-bold" 
   for="password">
    Password
    </label>
   <input class="my-4 w-full resize-y border rounded focus:outline-none focus:shadow-outline" 
    id="password"
    name="password"
    type="password"
    >
    <label class="my-4 text-xl text-left text-black font-bold" 
    for="password_confirmation">
    Password Confirmation
    </label>
   <input class="my-4 w-full resize-y border rounded focus:outline-none focus:shadow-outline" 
    id="password_confirmation"
    name="password_confirmation"
    type="password"
    >
    <button class="bg-blue-500 shadow hover:bg-blue-700 text-black font-bold py-2 px-2 rounded-full mr-2" 
    type="submit">Submit
    </button>
</form>
@endsection