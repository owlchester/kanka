<?php /** @var \App\User $user */?>
@extends('layouts.app', [
    'title' => __('settings.profile.title'),
    'description' => __('settings.profile.description'),
    'breadcrumbs' => false
])

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-lg-2 col-sm-4">
            @include('settings.menu')
        </div>
        <div class="col-lg-10 col-sm-8">
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
                                        <img src="{{ Storage::url(auth()->user()->avatar) }}"/>
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
                <div class="box-body">
                    <h2 class="page-header with-border">
                        {{ __('profiles.newsletter.title') }}
                    </h2>
                    <div class="form-group checkbox">
                        <label>
                            {!! Form::checkbox('mail_newsletter', 1, $user->mail_newsletter) !!}
                            {{ __('profiles.newsletter.settings.newsletter') }}</label>
                    </div>
                    <div class="form-group checkbox">
                        <label>
                            {!! Form::checkbox('mail_vote', 1, $user->mail_vote) !!}
                            {!! __('profiles.newsletter.settings.votes', ['vote' => link_to_route('community-votes.index', __('profiles.newsletter.links.community-vote'))]) !!}</label>
                    </div>
                    <div class="form-group checkbox">
                        <label>
                            {!! Form::checkbox('mail_release', 1, $user->mail_release) !!}
                            {!! __('profiles.newsletter.settings.releases', ['release' => link_to_route('releases.index', __('profiles.newsletter.links.release'))]) !!}</label>
                    </div>

                    <input type="hidden" id="newsletter-api" value="{{ route('settings.newsletter-api') }}" />
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script src="{{ mix('js/profile.js') }}" defer></script>
@endsection
