<div class="card flex-column w-1/2 mx-auto">
    <h1 class="text-center pb-3 text-lg font-bold">{{$title}}</h1>
    {{$form_title}}
    @csrf
    <div class="flex-column m-2">
        <label for="title" class="label">Title</label>
        <br>
        <input class="w-full pl-1" type="text" name="title" id="title" value="{{$project->title}}" required>
        @error('title')
        <span class="text-red-600" >
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="flex-column m-2">
        <label for="description" class="label">Description</label>
        <textarea class="w-full text-left" placeholder="Add some description..." name="description" id="description" rows="5" required> {{$project->description}}</textarea>
        @error('description')
        <span class="text-red-600" >
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="flex m-2 items-end">
        {{$submit}}
    </div>
    </form>
</div>