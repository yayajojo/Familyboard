<div class="card">
    <ul class="text-sm">
    @foreach($project->activities as $activity)
   <x-activity-component 
   :activity='$activity' 
   :action='explode("_", $activity->description)[0]' 
   :mission='explode("_", $activity->description)[1]??"project"' 
   />
    @endforeach
    </ul>
</div>