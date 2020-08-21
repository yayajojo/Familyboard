<form class=" bg-blue-200" action="{{route('project.destory',compact('project'))}}" method="post">
    @csrf
    @method('DELETE')
    <button class="button-add " type="submit">Delete</button>
</form>