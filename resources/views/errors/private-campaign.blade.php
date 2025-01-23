@extends('layouts.error', [
    'error' => 403
])

@section('content')
    <h2>{{ __('errors.private-campaign.title') }}</h2>
    @guest
        <p class="lg:max-w-2xl mx-auto text-center">
            {{ __('errors.private-campaign.guest.helper') }}
        </p>
        <p class="lg:max-w-2xl mx-auto text-center">
            <a href="{{ route('login') }}" class="btn-round rounded-full">{{ __('errors.private-campaign.guest.login') }}</a>
        </p>
    @else
        <p class="lg:max-w-2xl mx-auto text-center">
            {{ __('errors.private-campaign.auth.helper') }}
        </p>
    @endguest

@endsection
