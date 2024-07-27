@extends('base')

@section('nav')
    <div class="text-gray-200">
        <a href="{{ route('base') }}">
            <div>Home</div>
        </a>
        <a href="{{ route('player.list') }}">
            <div>Back</div>
        </a>
    </div>
@endsection

@section('content')
    <div class="bg-gray-800 text-gray-200 px-4">
        <div class="font-semibold">{{ $data->player_name }}</div>
        <div>Games: {{ $data->games }} <a
                href="{{ route('player.games', ['player' => $data->player_name]) }}"><button>Your games</button></a></p>
        <div>Victories: {{ $data->wins }}</div>
        <div>Deaths: {{ $data->deaths }}</div>
        <div>Best score: {{ $data->best }}</div>
        <div>Total gold: {{ $data->totalgold }}</div>
        <div>Artifact 5: {{ $data->art5 }}</div>
        <div>Artifact 7: {{ $data->art7 }}</div>
        <div>Artifact 10: {{ $data->art10 }}</div>
        <div>Artifact 12: {{ $data->art12 }}</div>
        <div>Artifact 15: {{ $data->art15 }}</div>
        <div>Artifact 17: {{ $data->art17 }}</div>
        <div>Artifact 20: {{ $data->art20 }}</div>
        <div>Artifact 25: {{ $data->art25 }}</div>
        <div>Artifact 30: {{ $data->art30 }}</div>
    </div>
@endsection
