@extends('layouts.app', [
    'title' => __('settings.api.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'centered' => true,
])

@section('content')
    <x-hero>
        <x-slot name="title">{{ __('settings.api.title') }}</x-slot>
        <x-slot name="subtitle">{{ __('settings.api.helper') }}</x-slot>
        <x-slot name="link">
            <a href="{{ route('larecipe.index') }}" class="">
                <x-icon class="link" />
                {{ __('front.features.api.link') }}
            </a>
        </x-slot>
    </x-hero>

    <x-grid type="1/1" id="api">
        @include('partials.errors')

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
