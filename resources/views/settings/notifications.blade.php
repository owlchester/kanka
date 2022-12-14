<?php /** @var \App\User $user */?>
@extends('layouts.app', [
    'title' => __('profiles.newsletter.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'noads' => true,
])

@section('content')
    @include('partials.errors')

    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">
                {{ __('profiles.newsletter.title') }}
            </h3>
        </div>
        <div class="box-body">
            <p class="help-block">
             {{ __('profiles.newsletter.helpers.header') }}
            </p>
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
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script src="{{ mix('js/profile.js') }}" defer></script>
@endsection
