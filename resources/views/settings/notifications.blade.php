<?php /** @var \App\Models\User $user */?>
@extends('layouts.app', [
    'title' => __('profiles.newsletter.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'centered' => true,
])

@section('content')
    <x-hero>
        <x-slot name="title">
            {{ __('profiles.newsletter.title') }}
        </x-slot>
        <x-slot name="subtitle">
            {{ __('profiles.newsletter.helpers.header') }}
        </x-slot>
    </x-hero>
    <x-grid type="1/1">
        @include('partials.errors')
        <x-forms.field field="mail-release" :label="__('profiles.newsletter.options.monthly')">
            <x-checkbox :text="__('front/newsletter.groups.all')">
                <input type="checkbox" name="mail_release" value="1" @if (old('mail_release', $user->mail_release ?? false)) checked="checked" @endif />
            </x-checkbox>
        </x-forms.field>
    </x-grid>

    <input type="hidden" id="newsletter-api" value="{{ route('settings.newsletter-api') }}" />
@endsection

@section('scripts')
    @parent
    @vite('resources/js/profile.js')
@endsection
