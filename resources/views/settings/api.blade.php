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
    <div id="api" class="mb-5">
        <p class="text-lg">
            {{ __('settings.api.helper') }}
            <a href="{{ route('larecipe.index') }}" class="" target="_blank">
                <i class="fa-solid fa-external-link-square" aria-hidden="true"></i>
                {{ __('front.features.api.link') }}
            </a>.
        </p>

        <div class="flex flex-col gap-2 md:gap-5">
            <passport-personal-access-tokens></passport-personal-access-tokens>
            <passport-authorized-clients></passport-authorized-clients>

        @if (request()->has('clients'))
            <div>
            <passport-clients></passport-clients>
            </div>
        @endif
        </div>
    </div>
@endsection


@section('scripts')
    @vite('resources/js/api.js')
@endsection
