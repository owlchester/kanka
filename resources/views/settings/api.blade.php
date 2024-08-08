@extends('layouts.app', [
    'title' => __('settings.api.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'centered' => true,
])

@section('content')
    <x-grid type="1/1" id="api">
        @include('partials.errors')
        <h1 class="">
            {{ __('settings.api.title') }}
        </h1>

        <p class="text-lg">
            {{ __('settings.api.helper') }}
            <a href="{{ route('larecipe.index') }}" class="" target="_blank">
                <x-icon class="fa-solid fa-external-link-square" />
                {{ __('front.features.api.link') }}
            </a>.
        </p>

        <div class="flex flex-col xl:grid xl:grid-cols-2 gap-5">
            <passport-personal-access-tokens></passport-personal-access-tokens>
            <passport-authorized-clients></passport-authorized-clients>

        @if (request()->has('clients'))
            <passport-clients></passport-clients>
        @endif
        </div>
    </x-grid>
@endsection


@section('scripts')
    @vite('resources/js/api.js')
@endsection
