@extends('base')

@section('title')
    <h2>{{ __('gameoptions.newgame') }}</h2>
@endsection

@section('nav')
    <div class="grid grid-cols-3 gap-4 justify-items-center">
        <a href="{{ route('base') }}">
            <div class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 text-base font-medium">
                Home
            </div>
        </a>
        <a href="{{ route('player.list') }}">
            <div class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 text-base font-medium">
                {{ __('gameoptions.players') }}
            </div>
        </a>
        <a href="{{ route('gamelist') }}">
            <div class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 text-base font-medium">
                {{ __('gameoptions.games') }}
            </div>
        </a>
    </div>
@endsection

@section('content')
    <div class="flex flex-wrap">
        <div class="basis-1/2 p-4">
            <h3>{{ __('gameoptions.choose') }}</h3>
            <form action="{{ route('playersSelect') }}" method="post">
                @csrf
                @for ($i = 1; $i <= 6; $i++)
                    <div class="mb-4">
                        <label for="player{{ $i }}" class="bg-gray-800 text-white font-medium p-1 block">Player
                            {{ $i }}</label>
                        <select name="player{{ $i }}" id="player{{ $i }}"
                            class="w-full mt-2 p-2 border border-gray-300 rounded-md">
                            @foreach ($players as $player_name)
                                <option value="{{ $player_name }}">{{ $player_name }}</option>
                            @endforeach
                            <option selected="selected" value="">none</option>
                        </select>
                    </div>
                @endfor

                <button type="submit"
                    class="rounded-md bg-gray-800 px-4 py-2 text-gray-300 font-medium hover:bg-gray-700 hover:text-white">Next</button>
            </form>
        </div>

        <div class="basis-1/2 p-4">
            <h2>{{ __('gameoptions.newplayertitle') }}</h2>

            <div class="newplayer">
                <h3>{{ __('gameoptions.createplayer') }}</h3>
                <form action="{{ route('player.create') }}" method="post">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block font-medium">Name</label>
                        <input id="name" type="text" name="player_name" placeholder="Add player name"
                            class="w-full mt-2 p-2 border border-gray-300 rounded-md">
                    </div>
                    <button type="submit"
                        class="rounded-md bg-gray-800 px-4 py-2 text-gray-300 font-medium hover:bg-gray-700 hover:text-white">Create</button>
                </form>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger mt-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
@endsection
