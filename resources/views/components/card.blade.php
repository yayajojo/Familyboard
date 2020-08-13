
    <div class="card m-4" style="height:300px">
        <h3 class="font-normal text-xl py-4 -ml-5 border-l-4 pl-4 border-purple-400">{{$project->title}}</h3>
        <a class="text-gray" href="{{route('project.show',$project)}}">
            {{ Illuminate\Support\Str::limit($project->description,100)}}
        </a>
    </div>
