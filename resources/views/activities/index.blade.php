<div class="card">
    <ul class="text-sm">
        @foreach($activities as $activity)
        @if($activity->recordable instanceof App\Task)
        <x-task-activity :activity='$activity' :action='explode("_", $activity->description)[0]'  />
        @elseif($activity->recordable instanceof App\Project)
        <x-project-activity :activity='$activity' :action='explode("_", $activity->description)[0]' />
        @endif
        @endforeach
    </ul>
</div>