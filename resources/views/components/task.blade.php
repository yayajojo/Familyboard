<div class="mb-3 card flex-col">
    <div class="my-5 {{$task->completed?'text-gray-500':''}}">{{$task->assignee->name}}: {{$task->body}} </div>
    <div class="flex justify-between">
        <div>
            <span>Start:</span>
            <input class="mr-1" type="datetime-local" value="{{\Carbon\Carbon::parse($task->start)->format('Y-m-d\TH:i')}}" name="start" id="start">
        </div>
        <div>
            <span>Due:</span>
            <input class="mr-1" type="datetime-local" value="{{\Carbon\Carbon::parse($task->due)->format('Y-m-d\TH:i')}}" name="due" id="due">
        </div>
        @if(\Carbon\Carbon::parse($task->due)->lt(\Carbon\Carbon::now())&&!$task->completed)
        <span class="bg-red-700 mx-3 px-2">Due</span>
        @elseif($task->completed == 0)
        <span class="bg-green-500 text-black mx-3 px-2">Uncompleted</span>
        @else
        <span class="bg-yellow-500 text-black mx-3 px-2">completed</span>
        @endif
        <form method="GET" action="{{route('task.edit',['project'=>$task->project,'task'=>$task])}}">
            <button class="button-add" type="submit">update</button>
        </form>
    </div>
</div>