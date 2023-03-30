@extends('layouts.app', [
    'title' => trans('settings.api.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'noads' => true,
])

@section('content')
    @include('partials.errors')
    <div class="max-w-4xl">
        <h1 class="mb-3">
            {{ __('settings.api.title') }}

            <a href="/{{ app()->getLocale() }}{{ config('larecipe.docs.route') }}/1.0/overview" class="btn btn-info float-right" target="_blank">
                <i class="fa-solid fa-external-link-square" aria-hidden="true"></i>
                {{ __('front.features.api.link') }}
            </a>
        </h1>
        <p class="text-lg">
            {{ __('settings.api.helper') }}
        </p>

        <div class="grid md:grid-cols-2 gap-2" id="api">
                <div class="box box-solid">
                    <div class="box-body">

                        <passport-authorized-clients></passport-authorized-clients>
                        <passport-personal-access-tokens></passport-personal-access-tokens>
                    </div>
                </div>

            @if (request()->has('clients'))

                <div class="box box-solid">
                    <div class="box-body">

                        <passport-clients></passport-clients>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection


@section('scripts')
    @vite('resources/js/api.js')
@endsection
