<h1>New player</h1>

<div class="newplayer">

    <h3>Add new player</h5>
        <form action="{{ route('newPlayer') }}" method="post">
            @csrf

            <label for="name" class="">Name</label>
            <input id="name" class="" type="text" name="player_name" required>
            <button class="" type="submit">Create</button>

        </form>
</div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<a href="{{ route('base') }}"><button>Home</button></a>
