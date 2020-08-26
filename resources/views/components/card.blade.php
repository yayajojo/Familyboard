<div class="card mb-3 flex flex-col" style="height:300px">
    <h3 class="font-normal text-xl py-4 -ml-5 border-l-4 pl-4 border-purple-400">{{$project->title}}</h3>
    @if(url()->current() === route('project.index'))
    <a class="text-gray flex-1" href="{{route('project.show',$project)}}">
        {{ Illuminate\Support\Str::limit($project->description,200)}}
    </a>
    @else
    <div class="text-gray flex-1">
        {{ $project->description}}
    </div>
    @endif
    @can('delete',$project)
    <x-delete-project :project='$project' />
    @endcan
</div>