<div class="card flex-column w-1/2 mx-auto">
    <h1 class="text-center pb-3 text-lg font-bold">Create a Project</h1>
    <form action="{{route('project.store')}}" method="post">
        @csrf
        <div class="flex-column m-2">
            <label for="title" class="label">Title</label>
            <br>
            <input class="w-full" type="text" name="title" id="title">
        </div>
        <div class="flex-column m-2">
            <label for="description" class="label">Description</label>
            <textarea class="pl-2 w-full text-left" placeholder="Add some description..." name="description" id="description" rows="5"> </textarea>
        </div>
        <div class="flex m-2 items-end">
            <button class="button-add mr-8 " type="submit">
                Create Project
            </button>
            <a class="underline" href="{{route('project.index')}}">Cancel</a>
        </div>
    </form>
</div>