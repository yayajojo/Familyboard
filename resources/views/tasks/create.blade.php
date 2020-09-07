<div class="card mb-3">
    <form action="{{route('task.store',compact('project'))}}" method="post">
        @csrf
        <div class="my-3">
            <label for="task-title">Create Task</label>
            <input id="task-title" autocomplete="off" class="pl-2 w-full outline-none focus:shadow-outline" name="body" placeholder="Begin adding tasks...">
        </div>
        <div class="my-3 flex items-center justify-between">
            <div >
                <label for="start">Start Date</label>
                <input id="start" type="datetime-local" name="start" min="{{\Carbon\Carbon::now()}}" required>
            </div>
            <div >
                <label for="due">Due Date</label>
                <input id="due" type="datetime-local" name="due" min="{{\Carbon\Carbon::now()}}" required>
            </div>
            <button class="button-add my-2" type="submit">create</button>
        </div>
    </form>
</div>