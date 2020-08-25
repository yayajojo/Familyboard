@if($action ==='created')
<li>@ {{$activity->user->name}} has {{$action}} a project: {{$activity->created_at->diffForHumans()}}</li>
@else
@if(count($activity->changes['after']) === 1)
<li>@ {{$activity->user->name}} has {{$action}} the {{array_keys($activity->changes['after'])[0]}} of the project: {{$activity->created_at->diffForHumans()}}</li>
@else
<li>@ {{$activity->user->name}} has {{$action}} the project: {{$activity->created_at->diffForHumans()}}</li>
@endif
@endif