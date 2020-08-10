<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Birdboard</title>
</head>

<body>
    <ul>
        @forelse($projects as $project)
        <li>
            <a href="{{route('project.show',$project)}}"> 
                {{$project->title}}
            </a>
        </li>
        @empty
        <li>No project yet!</li>
        @endforelse
    </ul>
</body>

</html>