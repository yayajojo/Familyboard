<div class="flex mr-5">
    @foreach($project->members as $member)

    <img class="rounded-full mx-2" src="{{gravatar_url($member->email)}}" alt="member_avatar">

    @endforeach
    <img class="rounded-full" src="{{gravatar_url($project->owner->email)}}" alt="owner_gravartar">
</div>