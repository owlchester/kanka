<?php /** @var \App\User $user */?>
@extends('layouts.app', [
    'title' => __('settings.account.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'noads' => true,
])

@section('content')
    @include('partials.errors')
    <div class="row mb-5">
        <div class="col-md-6">
            {!! Form::model($user, ['method' => 'PATCH', 'route' => ['settings.account.email']]) !!}
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        {{ __('settings.account.email') }}
                    </h3>
                </div>
                <div class="box-body">
                    <div class="form-group required">
                        <label>{{ __('profiles.fields.email') }}</label>
                        {!! Form::text('email', null, ['placeholder' => __('profiles.placeholders.email'), 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="box-footer text-right">

                    <button class="btn btn-primary">
                        {{ __('settings.account.actions.update_email') }}
                    </button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
        <div class="col-md-6">
            <div class="box box-solid">
                @if (!$user->isSocialLogin())
                <div class="box-header with-border">
                    <h3 class="box-title">
                        {{ __('settings.account.password') }}
                    </h3>
                </div>
                {!! Form::model($user, ['method' => 'PATCH', 'route' => ['settings.account.password']]) !!}
                <div class="box-body">
                    <div class="form-group">
                        <label>{{ __('profiles.fields.new_password') }}</label>
                        {!! Form::password('password_new', ['placeholder' => __('profiles.placeholders.new_password'), 'class' => 'form-control']) !!}
                    </div>
                    <div class="form-group">
                        <label>{{ __('profiles.fields.new_password_confirmation') }}</label>
                        {!! Form::password('password_new_confirmation', ['placeholder' => __('profiles.placeholders.new_password_confirmation'), 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="box-footer text-right">
                    <button class="btn btn-primary">
                        {{ __('settings.account.actions.update_password') }}
                    </button>
                </div>
                {!! Form::close() !!}
                @else
                <div class="box-header with-border">
                    <h3 class="box-title">
                        {{ __('settings.account.social.title') }}
                    </h3>
                </div>
                {!! Form::model($user, ['method' => 'PATCH', 'route' => ['settings.account.social']]) !!}

                <div class="box-body">

                    <p class="help">{{ __('settings.account.social.helper', ['provider' => ucfirst($user->provider)]) }}</p>
                    <div class="form-group">
                        <label>{{ __('profiles.fields.new_password') }}</label>
                        {!! Form::password('password_new', ['placeholder' => __('profiles.placeholders.new_password'), 'class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="box-footer text-right">
                    <button class="btn btn-primary">
                        {{ __('settings.account.actions.social') }}
                    </button>
                </div>
                {!! Form::close() !!}
                @endif
            </div>
        </div>
    </div>

    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title text-red">
                {{ __('profiles.sections.dangerzone') }}
            </h3>
        </div>
        <div class="box-body">
            @if (!auth()->user()->subscribed('kanka') || auth()->user()->subscription('kanka')->cancelled())
            <button class="btn btn-danger pull-right" data-toggle="modal" data-target="#delete-account">
                <i class="fa-solid fa-exclamation-triangle" aria-hidden="true"></i> {{ __('profiles.sections.delete.delete') }}
            </button>
            @endif

            <strong>
                {{ __('profiles.sections.delete.title') }}
            </strong><br />
            <p>{{ __('profiles.sections.delete.helper') }}</p>


            @if (auth()->user()->subscribed('kanka') && !auth()->user()->subscription('kanka')->cancelled())
                <p class="text-red">
                    {!! __('profiles.sections.delete.subscribed', [
    'subscription' => link_to_route('settings.subscription', __('settings.menu.subscription'))
]) !!}
                </p>
            @endif
        </div>
    </div>
@endsection

@section('modals')
    @parent
    <div class="modal fade" id="delete-account" tabindex="-1" role="dialog" aria-labelledby="deleteAccountLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-2xl">
                <div class="modal-body text-center">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4>
                        {{ __('profiles.sections.delete.title') }}
                    </h4>

                    <p class="mt-3">
                        {{ __('profiles.sections.delete.helper') }}
                    </p>
                    <p class="mt-3">
                        {{ __('profiles.sections.delete.warning') }}
                    </p>
                    <p class="mt-3">
                        {{ __('profiles.sections.delete.goodbye') }}
                    </p>

                    <div class="py-5">
                        {!! Form::model($user, ['method' => 'PATCH', 'route' => ['settings.account.destroy']]) !!}
                        <div class="form-group required">
                        {!! Form::text('goodbye',null, ['class' => 'form-control']) !!}
                    </div>
                        <button type="submit" class="btn btn-danger rounded-full px-8">
                            <i class="fa-solid fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ __('profiles.sections.delete.confirm') }}
                        </button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
