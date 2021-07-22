<?php /** @var \App\User $user */?>
@extends('layouts.app', [
    'title' => __('settings.profile.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'noads' => true,
])

@section('content')
    @include('partials.errors')
    {!! Form::model($user, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'route' => ['settings.profile']]) !!}
    <div class="box box-solid">
        <div class="box-body">
            <div class="row">
                <div class="col-md-6">
                    <h2 class="page-header with-border">
                        {{ __('settings.profile.title') }}
                    </h2>

                    <div class="form-group required">
                        <label>{{ __('profiles.fields.name') }}</label>
                        {!! Form::text('name', null, ['placeholder' => __('profiles.placeholders.name'), 'class' => 'form-control']) !!}
                    </div>

                    <hr />

                    <div class="form-group checkbox">
                        <label>
                            {!! Form::hidden('has_last_login_sharing', 0) !!}
                            {!! Form::checkbox('has_last_login_sharing') !!}
                            {{ __('profiles.fields.last_login_share') }}</label>
                    </div>

                    @if (auth()->user()->isPatron())
                        <hr />
                        <div class="form-group checkbox">
                            <label>
                                {!! Form::hidden('settings[hide_subscription]', 0) !!}
                                {!! Form::checkbox('settings[hide_subscription]') !!}
                                {!! __('profiles.fields.hide_subscription', [
    'hall_of_fame' => link_to_route('front.hall-of-fame', __('front/hall-of-fame.title'), null, ['target' => '_blank'])
]) !!}</label>
                        </div>
                    @endif
                </div>
                <div class="col-md-4 col-md-offset-2">
                    <h2 class="page-header with-border">
                        {{ __('settings.profile.avatar') }}
                    </h2>


                    {!! Form::file('avatar', ['class' => 'image form-group']) !!}
                    {!! Form::hidden('remove-avatar') !!}

                    @if (!empty(auth()->user()->avatar) && auth()->user()->avatar != 'users/default.png')
                        <div class="preview">
                            <div class="image">
                                <img src="{{ auth()->user()->getAvatarUrl(200) }}"/>
                                <a href="#" class="img-delete" data-target="remove-avatar" title="{{ __('crud.remove') }}">
                                    <i class="fa fa-trash"></i> {{ __('crud.remove') }}
                                </a>
                            </div>
                            <br class="clear">
                        </div>
                    @endif

                </div>
            </div>

            <button class="btn btn-primary">
                {{ __('settings.profile.actions.update_profile') }}
            </button>
        </div>
    </div>
    {!! Form::close() !!}

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
            <div class="form-group checkbox margin-bottom">
                <label>
                    {!! Form::checkbox('mail_newsletter', 1, $user->mail_newsletter) !!}
                    {{ __('profiles.newsletter.options.monthly') }}
                </label>
                <p class="help-block">
                    {{ __('profiles.newsletter.helpers.monthly') }}
                </p>
            </div>
            <div class="form-group checkbox margin-bottom">
                <label>
                    {!! Form::checkbox('mail_vote', 1, $user->mail_vote) !!}
                    {!! __('front/community-votes.title') !!}
                </label>

                <p class="help-block">
                    {!! __('profiles.newsletter.helpers.community-vote', ['community-vote' => link_to_route('community-votes.index', __('profiles.newsletter.links.community-vote'))]) !!}
                </p>
            </div>
            <div class="form-group checkbox">
                <label>
                    {!! Form::checkbox('mail_release', 1, $user->mail_release) !!}
                    {!! __('profiles.newsletter.options.release', ['news' => link_to_route('front.news', __('profiles.newsletter.links.updates'))]) !!}
                </label>
                <p class="help-block">
                    {{ __('profiles.newsletter.helpers.release') }}
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
