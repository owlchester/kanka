@extends('layouts.app', [
    'title' => __('settings.api.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'noads' => true,
])

@section('content')
    @include('partials.errors')
    <div class="max-w-4xl">
        <h1 class="mb-3">
            {{ __('settings.api.title') }}
        </h1>
        <p class="text-lg">
            {{ __('settings.api.helper') }}
            <a href="/{{ app()->getLocale() }}{{ config('larecipe.docs.route') }}/1.0/overview" class="" target="_blank">
                <i class="fa-solid fa-external-link-square" aria-hidden="true"></i>
                {{ __('front.features.api.link') }}
            </a>.
        </p>

        <div class="rounded p-2 bg-box mb-5" id="api">
            <passport-authorized-clients></passport-authorized-clients>
            <passport-personal-access-tokens></passport-personal-access-tokens>
        </div>

        @if (request()->has('clients'))

        <div class="rounded p-2 bg-box mb-5" id="api">
            <passport-clients></passport-clients>
        </div>
        @endif
    </div>
@endsection


@section('scripts')
    @vite('resources/js/api.js')
@endsection
