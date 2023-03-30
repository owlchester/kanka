<?php /** @var \App\User $user */?>
@extends('layouts.app', [
    'title' => __('settings.profile.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'noads' => true,
])

@section('content')
    <div class="max-w-3xl">
        <h1 class="mb-3">
            {{ __('settings.profile.title') }}
        </h1>
        @include('partials.errors')

        {!! Form::model($user, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'route' => ['settings.profile'], 'data-shortcut' => 1]) !!}
        <div class="rounded p-4 bg-box">
            <div class="flex flex-col md:flex-row gap-5">
                <div class="md:grow">
                    <div class="mb-5">
                        <label>{{ __('profiles.fields.name') }} <span class="text-red">*</span></label>
                        {!! Form::text('name', null, ['placeholder' => __('profiles.placeholders.name'), 'class' => 'rounded border p-2 w-full']) !!}
                    </div>

                    <div class="mb-5">
                        <label class="inline-block w-full font-bold mb-1">
                            {{ __('profiles.fields.profile-name') }}
                        </label>
                        {!! Form::text('settings[marketplace_name]', null, ['class' => 'rounded border p-2 w-full', 'maxlength' => 32]) !!}
                        <p class="help-block">
                            {!! __('profiles.helpers.profile-name', [
    'marketplace' => link_to(config('marketplace.url'), __('front.menu.marketplace'), ['target' => '_blank']),
    'profile' => link_to_route('users.profile', __('profiles.settings.helpers.profile'), $user, ['target' => '_blank'])]) !!}
                        </p>
                    </div>

                    <div class="mb-5">
                        <label class="inline-block w-full font-bold mb-1">
                            {{ __('profiles.fields.bio') }}
                        </label>
                        {!! Form::textarea('profile[bio]', null, ['placeholder' => __('profiles.placeholders.bio'), 'class' => 'rounded border p-2 w-full', 'rows' => 5, 'maxlength' => 300]) !!}
                        <p class="help-block">
                            {!!  __('profiles.settings.helpers.bio', [
    'link' => link_to_route('users.profile', __('profiles.settings.helpers.profile'), $user, ['target' => '_blank'])
    ]) !!}
                        </p>
                    </div>

                    <div class="form-group checkbox mb-5">
                        <label class="inline-block w-full font-bold mb-1">
                            {!! Form::hidden('has_last_login_sharing', 0) !!}
                            {!! Form::checkbox('has_last_login_sharing') !!}
                            {{ __('profiles.fields.last_login_share') }}</label>
                    </div>

                    @if (auth()->user()->isSubscriber())
                        <div class="form-group checkbox">
                            <label class="inline-block w-full font-bold mb-1">
                                {!! Form::hidden('settings[hide_subscription]', 0) !!}
                                {!! Form::checkbox('settings[hide_subscription]', 1) !!}
                                {!! __('profiles.fields.hide_subscription', [
    'hall_of_fame' => link_to_route('front.hall-of-fame', __('front/hall-of-fame.title'), null, ['target' => '_blank'])
]) !!}</label>
                        </div>
                    @endif
                </div>
                <div class="md:flex-0">
                    <label class="inline-block w-full font-bold mb-1">
                        {{ __('settings.profile.avatar') }}
                    </label>
                    {!! Form::file('avatar', ['class' => 'image form-group']) !!}

                    @if (!empty(auth()->user()->avatar) && auth()->user()->avatar != 'users/default.png')
                        <div class="rounded-full">
                            <img class="avatar rounded-full avatar-user" src="{{ auth()->user()->getAvatarUrl(200) }}" width="200" height="200" alt="{{ auth()->user()->name }}">
                        </div>

                    @endif

                </div>
            </div>
            <div class="text-right">
                <button class="btn btn-primary">
                    {{ __('settings.profile.actions.update_profile') }}
                </button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
