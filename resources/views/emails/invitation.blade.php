<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    {{strtoupper($invitedUser->name)}} has been invited to join the project
    {{$project->title}}.
    Click <a href="{{route('project.show',['project'=>$project])}}">this</a> to join the project
    
</body>

</html>