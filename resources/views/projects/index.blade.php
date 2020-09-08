@extends('layouts.nav')
@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
<header class="flex items-end px-4 py-4 justify-between">
  <div class="my-5 flex">
    <span class="text-xl px-2 ">My Projects</span>
    <form action="" method="post">
      <button class="button-add" type="submit">Update profile</button>
    </form>
  </div>
  <form class="text-sm px-2" action="{{route('project.create')}}" method="get">
    <button class="button-add" type="submit">
      Add Project
    </button>
  </form>
</header>
<div class="flex flex-wrap">
  @forelse($projects as $project)
  <div class="lg:w-1/3 px-2 py-2">
    <x-card :project="$project" />
  </div>
  @empty
  <div class="lg:w-1/3 card m-4">
    <h3 class="font-normal text-xl py-4">

      No project yet!

    </h3>
  </div>
  @endforelse
</div>
@endsection

@section('footer')

@endsection