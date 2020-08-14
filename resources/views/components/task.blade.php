<div class="mb-3 card">

<form  class="flex items-end" action="{{$task->path()}}" method="post">
    @csrf
    {{ method_field('PATCH') }}
    <input class="mr-1 {{$task->completed?'text-gray-500':''}} outline-none focus:shadow-outline w-full bg-blue-200" type="text" name="body" value="{{$task->body}}">
    <input {{$task->completed?'checked':''}} type="checkbox" name="completed" onchange="this.form.submit()">
</form>

</div>