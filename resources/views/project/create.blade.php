<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>

<body>
    <h1>Create a Project</h1>
    <form class="container" action="{{route('project.store')}}" method="post">
        @csrf
        <div class="field">
            <label for="title" class="label">Title</label>
            <div class="control">
                <input class="input" type="text" name="title" id="title">
            </div>
        </div>
        <div class="field">
            <label for="description" class="label">Description</label>
            <div class="control">
                <textarea class="input" name="description" id="description" cols="30" rows="10"></textarea>
            </div>
        </div>
        <div class="field">
            <div class="control">
                <button type="submit">
                    Create Project
                </button>
            </div>
        </div>

    </form>
</body>

</html>