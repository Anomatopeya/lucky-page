@extends('app')

@section('content')
    <div class="text-center">
        <h1 class="text-4xl font-bold text-gray-700 p-5">
            {{__('messages.welcome_lucky_page', ['name' => $user->name])}}
        </h1>
    </div>

    <x-link-block :userLink="$userLink"/>
    <x-game-block :userLink="$userLink"/>

@endsection

