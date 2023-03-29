@extends('layouts.app', [
    'title' => trans('settings.api.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'noads' => true,
])

@section('content')
    @include('partials.errors')
    <div class="max-w-3xl">
        <div class="alert alert-info">
            <p>{{ __('settings.api.helper') }}</p>
            <a href="/{{ app()->getLocale() }}{{ config('larecipe.docs.route') }}/1.0/overview" class="btn btn-info" target="_blank">
                <i class="fa-solid fa-external-link-square" aria-hidden="true"></i>
                {{ __('front.features.api.link') }}
            </a>
        </div>
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
