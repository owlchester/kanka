<?php /** @var \App\User $user */?>
@extends('layouts.app', [
    'title' => __('profiles.newsletter.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'noads' => true,
])

@section('content')
    @include('partials.errors')
    <h1 class="mb-3">
        {{ __('profiles.newsletter.title') }}
    </h1>
    <p class="text-lg">
        {{ __('profiles.newsletter.helpers.header') }}
    </p>
    <x-box>
        <div class="form-group checkbox">
            <label>
                {!! Form::checkbox('mail_release', 1, $user->mail_release) !!}
                {!! __('profiles.newsletter.options.monthly') !!}
            </label>
            <p class="help-block">
                {{ __('front/newsletter.groups.all') }}
            </p>
        </div>

        <input type="hidden" id="newsletter-api" value="{{ route('settings.newsletter-api') }}" />
    </x-box>
@endsection

@section('scripts')
    @parent
    @vite('resources/js/profile.js')
@endsection
