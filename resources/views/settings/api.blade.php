@extends('layouts.app', [
    'title' => __('settings.api.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'noads' => true,
])

@section('content')
    @include('partials.errors')
    <h1 class="mb-3">
        {{ __('settings.api.title') }}
    </h1>
    <div id="api">
        <p class="text-lg">
            {{ __('settings.api.helper') }}
            <a href="/{{ app()->getLocale() }}{{ config('larecipe.docs.route') }}/1.0/overview" class="" target="_blank">
                <i class="fa-solid fa-external-link-square" aria-hidden="true"></i>
                {{ __('front.features.api.link') }}
            </a>.
        </p>

        <x-box>
            <passport-authorized-clients></passport-authorized-clients>
            <passport-personal-access-tokens></passport-personal-access-tokens>
        </x-box>

        @if (request()->has('clients'))
        <x-box>
            <passport-clients></passport-clients>
        </x-box>
        @endif
    </div>
@endsection


@section('scripts')
    @vite('resources/js/api.js')
@endsection
