<div class="card my-3 flex flex-col ">
    <h3 class="font-normal text-xl py-4 -ml-5 border-l-4 pl-4 border-purple-400">
        Invite a member
    </h3>
    <form action="{{route('invitation.store',compact('project'))}}" method="post">
        @csrf
        <div class="flex flex-col my-3">
        <label for="email">Member email:</label>
        <input class="flex-1"type="email" name="email" id="email" required>
        </div>
        <button class="button-add " type="submit">Invite</button>
    </form>
    @error('email','invitation')
    <div class="text-red-700 my-2">{{ $message }}</div>
    @enderror
   
</div>