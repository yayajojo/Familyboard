<div class="flex mr-5">
    @foreach($project->members as $member)

    <img class="rounded-full border-blue-800 border mx-2 w-12 h-12" src="{{$member->profile->avatar??gravatar_url($member->email)}}" alt="member_avatar">

    @endforeach
    <img class="rounded-full border-green-800 border w-12 h-12" src="{{$project->owner->profile->avatar??gravatar_url($project->owner->email)}}" alt="owner_gravartar">
</div>