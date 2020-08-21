
    <div class="card mb-3 flex flex-col justify-between" style="height:300px">
        <h3 class="font-normal text-xl py-4 -ml-5 border-l-4 pl-4 border-purple-400">{{$project->title}}</h3>
        <a class="text-gray" href="{{route('project.show',$project)}}">
            {{ Illuminate\Support\Str::limit($project->description,200)}}
        </a>
        <x-delete-project :project='$project'/>
    </div>
