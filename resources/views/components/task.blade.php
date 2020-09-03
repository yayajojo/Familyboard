<div class="mb-3 card">

<form  class="flex items-end" action="{{$task->path()}}" method="post">
    @csrf
    {{ method_field('PATCH') }}
    <input class="mr-1 {{$task->completed?'text-gray-500':''}} outline-none focus:shadow-outline w-full bg-blue-200" type="text" name="body" value="{{$task->body}}" required>
    @if(\Carbon\Carbon::parse($task->due)->lt(\Carbon\Carbon::now())&&!$task->completed)
    <span class="bg-red-700 mx-1 px-2">Due</span>
    @endif
    <input class="mr-1"type="datetime-local" value="{{\Carbon\Carbon::parse($task->due)->format('yy-m-d\TH:m')}}" name="due" id="due">
    
    <input {{$task->completed?'checked':''}} 
    type="checkbox" 
    name="completed" 
    onchange="this.form.submit()"
    >
    
    
</form>

</div>