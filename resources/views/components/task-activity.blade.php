
<li>@ {{$activity->user->name}} has {{$action}} {{$action =='created'?'a':'the'}} task '{{$activity->recordable->body}}' : {{$activity->created_at->diffForHumans()}}</li>
