@extends('layouts.app')

@section('content')
<div class='relative'>
    <img class="rounded-lg mb-2" src="/images/heart-tree.jpg" alt="tree-heart">
    <img  style="left:50%"class=" w-32 rounded-full absolute bottom-0 transform -translate-x-1/2 translate-y-1/2" src="{{$user->getAvatar()}}" alt="avatar">
</div>
<div class="mt-2 flex justify-between items-center my-3">
    <div>
        <h2 style="max-width:230px" class="mb-1 font-bold text-2xl"> {{$user->name}}</h2>
        <p class="text-sm">Joined {{$user->created_at->diffForHumans()}}</p>
    </div>
    <div class="flex">
    @can('update', $profile)
    <x-edit-profile :user='$user'/>
    @endcan
    @if(!auth()->user()->is($user))
    <x-follow-button :user='$user'/>
    @endif
    </div>
</div>
<p class="text-sm mb-5">

{{$profile->body }}

</p>
<x-timeline :tweets="$tweets" />
@endsection