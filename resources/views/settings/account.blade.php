<?php /** @var \App\User $user */?>
@extends('layouts.app', [
    'title' => __('settings.account.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'noads' => true,
])

@section('content')
    <div class="max-w-4xl">
        @include('partials.errors')

        <h3 class="mb-3">
            {{ __('settings.account.email') }}
        </h3>
        {!! Form::model($user, ['method' => 'PATCH', 'route' => ['settings.account.email']]) !!}
        <div class="rounded p-4 bg-box mb-5">
            <div class="form-group required">
                <label>{{ __('profiles.fields.email') }}</label>
                {!! Form::email('email', null, ['placeholder' => __('profiles.placeholders.email'), 'class' => 'form-control']) !!}
            </div>
            <div class="text-right">
                <button class="btn btn-primary">
                    {{ __('settings.account.actions.update_email') }}
                </button>
            </div>
        </div>
        {!! Form::close() !!}


        @if (!$user->isSocialLogin())
            <h3 class="mb-3">
                {{ __('settings.account.password') }}
            </h3>
            <div class="rounded p-4 mb-5 bg-box">
            {!! Form::model($user, ['method' => 'PATCH', 'route' => ['settings.account.password']]) !!}
                <div class="form-group">
                    <label>{{ __('profiles.fields.new_password') }}</label>
                    {!! Form::password('password_new', ['placeholder' => __('profiles.placeholders.new_password'), 'class' => 'form-control']) !!}
                </div>
                <div class="form-group">
                    <label>{{ __('profiles.fields.new_password_confirmation') }}</label>
                    {!! Form::password('password_new_confirmation', ['placeholder' => __('profiles.placeholders.new_password_confirmation'), 'class' => 'form-control']) !!}
                </div>

                <div class="text-right">
                    <button class="btn btn-primary">
                        {{ __('settings.account.actions.update_password') }}
                    </button>
                </div>
            </div>
            {!! Form::close() !!}
        @else
            <h2 class="mb-3">
                {{ __('settings.account.social.title') }}
            </h2>
            {!! Form::model($user, ['method' => 'PATCH', 'route' => ['settings.account.social']]) !!}
            <div class="rounded p-4 mb-5 bg-box">
                <p class="help">{{ __('settings.account.social.helper', ['provider' => ucfirst($user->provider)]) }}</p>
                <div class="form-group">
                    <label>{{ __('profiles.fields.new_password') }}</label>
                    {!! Form::password('password_new', ['placeholder' => __('profiles.placeholders.new_password'), 'class' => 'form-control']) !!}
                </div>
                <div class="text-right">
                    <button class="btn btn-primary">
                        {{ __('settings.account.actions.social') }}
                    </button>
                </div>
            </div>
            {!! Form::close() !!}
        @endif

        @includeWhen(config('google2fa.enabled'), 'settings._tfa')

        <h3 class="mb-3 text-red">
            {{ __('profiles.sections.dangerzone') }}
        </h3>
        <div class="rounded p-4 mb-5 bg-box">
            @if (!auth()->user()->subscribed('kanka') || auth()->user()->subscription('kanka')->canceled())
            <button class="btn btn-danger pull-right" data-toggle="modal" data-target="#delete-account">
                <i class="fa-solid fa-exclamation-triangle" aria-hidden="true"></i> {{ __('profiles.sections.delete.delete') }}
            </button>
            @endif

            <strong>
                {{ __('profiles.sections.delete.title') }}
            </strong><br />
            <p>{{ __('profiles.sections.delete.helper') }}</p>


            @if (auth()->user()->subscribed('kanka') && !auth()->user()->subscription('kanka')->canceled())
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
                    <div class="py-5">
                        <p>
                            {!! __('profiles.sections.delete.goodbye', ['code' => '<code>goodbye</code>']) !!}
                        </p>
                            {!! Form::model($user, ['method' => 'PATCH', 'route' => ['settings.account.destroy']]) !!}
                        <div class="form-group required">
                            {!! Form::text('goodbye',null, ['class' => 'form-control','required']) !!}
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
