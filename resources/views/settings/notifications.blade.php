<?php /** @var \App\User $user */?>
@extends('layouts.app', [
    'title' => __('profiles.newsletter.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'noads' => true,
    'centered' => true,
])

@section('content')
    <x-grid type="1/1">
        @include('partials.errors')
        <h1 class="">
            {{ __('profiles.newsletter.title') }}
        </h1>
        <p class="text-lg">
            {{ __('profiles.newsletter.helpers.header') }}
        </p>
        <x-forms.field field="mail-release" :label="__('profiles.newsletter.options.monthly')">
            <label class="text-neutral-content cursor-pointer flex gap-2">
                {!! Form::checkbox('mail_release', 1, $user->mail_release) !!}
                <span>{{ __('front/newsletter.groups.all') }}</span>
            </label>
        </x-forms.field>
    </x-grid>

    <input type="hidden" id="newsletter-api" value="{{ route('settings.newsletter-api') }}" />
@endsection

@section('scripts')
    @parent
    @vite('resources/js/profile.js')
@endsection
