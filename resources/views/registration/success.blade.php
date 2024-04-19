@extends('app')

@section('content')
    <div class="bg-white p-6 rounded shadow-lg">
        <h1 class="text-2xl font-bold mb-4">{{__('messages.registration_success')}}</h1>
        <p class="text-gray-700">{!! __('messages.access_link_text', ['link' => route('lucky-page', ['token' => $token])]) !!}</p>
    </div>
@endsection
