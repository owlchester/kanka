<?php /** @var \App\User $user */?>
@extends('layouts.app', [
    'title' => __('settings.profile.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'noads' => true,
])

@section('content')
    <div class="max-w-3xl">
        @include('partials.errors')

        {!! Form::model($user, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'route' => ['settings.profile'], 'data-shortcut' => 1]) !!}
        <div class="box box-solid">
            <div class="box-header with-border">
                <h4 class="box-title with-border">
                    {{ __('settings.profile.title') }}
                </h4>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-7">
                        <div class="form-group required">
                            <label>{{ __('profiles.fields.name') }}</label>
                            {!! Form::text('name', null, ['placeholder' => __('profiles.placeholders.name'), 'class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                            <label>
                                {{ __('profiles.fields.profile-name') }}
                            </label>
                            {!! Form::text('settings[marketplace_name]', null, ['class' => 'form-control', 'maxlength' => 32]) !!}
                            <p class="help-block">
                                {!! __('profiles.helpers.profile-name', [
        'marketplace' => link_to(config('marketplace.url'), __('front.menu.marketplace'), ['target' => '_blank']),
        'profile' => link_to_route('users.profile', __('profiles.settings.helpers.profile'), $user, ['target' => '_blank'])]) !!}
                            </p>
                        </div>

                        <div class="form-group">
                            <label>
                                {{ __('profiles.fields.bio') }}
                            </label>
                            {!! Form::textarea('profile[bio]', null, ['placeholder' => __('profiles.placeholders.bio'), 'class' => 'form-control', 'rows' => 5, 'maxlength' => 300]) !!}
                            <p class="help-block">
                                {!!  __('profiles.settings.helpers.bio', [
        'link' => link_to_route('users.profile', __('profiles.settings.helpers.profile'), $user, ['target' => '_blank'])
        ]) !!}
                            </p>
                        </div>

                        <div class="form-group checkbox mb-5">
                            <label>
                                {!! Form::hidden('has_last_login_sharing', 0) !!}
                                {!! Form::checkbox('has_last_login_sharing') !!}
                                {{ __('profiles.fields.last_login_share') }}</label>
                        </div>

                        @if (auth()->user()->isSubscriber())
                            <div class="form-group checkbox">
                                <label>
                                    {!! Form::hidden('settings[hide_subscription]', 0) !!}
                                    {!! Form::checkbox('settings[hide_subscription]', 1) !!}
                                    {!! __('profiles.fields.hide_subscription', [
        'hall_of_fame' => link_to_route('front.hall-of-fame', __('front/hall-of-fame.title'), null, ['target' => '_blank'])
    ]) !!}</label>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-4 col-md-offset-1">
                        <label>
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
            </div>
            <div class="box-footer text-right">
                <button class="btn btn-primary">
                    {{ __('settings.profile.actions.update_profile') }}
                </button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
