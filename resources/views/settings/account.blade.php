<?php /** @var \App\User $user */?>
@extends('layouts.app', [
    'title' => __('settings.account.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'noads' => true,
])

@section('content')
    @include('partials.errors')

    <h3 class="mb-3">
        {{ __('settings.account.email') }}
    </h3>
    {!! Form::model($user, ['method' => 'PATCH', 'route' => ['settings.account.email']]) !!}
    <x-box>
        <div class="form-group required">
            <label>{{ __('profiles.fields.email') }}</label>
            {!! Form::email('email', null, ['placeholder' => __('profiles.placeholders.email'), 'class' => 'form-control']) !!}
        </div>
        <div class="text-right">
            <x-buttons.confirm type="primary">
                {{ __('settings.account.actions.update_email') }}
            </x-buttons.confirm>
        </div>
    </x-box>
    {!! Form::close() !!}


    @if (!$user->isSocialLogin())
        <h3 class="mb-3">
            {{ __('settings.account.password') }}
        </h3>
        <x-box>
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
                <x-buttons.confirm type="primary">
                    {{ __('settings.account.actions.update_password') }}
                </x-buttons.confirm>
            </div>
        </x-box>
        {!! Form::close() !!}
    @else
        <h2 class="mb-3">
            {{ __('settings.account.social.title') }}
        </h2>
        {!! Form::model($user, ['method' => 'PATCH', 'route' => ['settings.account.social']]) !!}
        <x-box>
            <p class="help">{{ __('settings.account.social.helper', ['provider' => ucfirst($user->provider)]) }}</p>
            <div class="form-group">
                <label>{{ __('profiles.fields.new_password') }}</label>
                {!! Form::password('password_new', ['placeholder' => __('profiles.placeholders.new_password'), 'class' => 'form-control']) !!}
            </div>
            <div class="text-right">
                <x-buttons.confirm type="primary">
                    {{ __('settings.account.actions.social') }}
                </x-buttons.confirm>
            </div>
        </x-box>
        {!! Form::close() !!}
    @endif

    @includeWhen(config('google2fa.enabled'), 'settings._tfa')

    <h3 class="mb-3 text-red">
        {{ __('profiles.sections.dangerzone') }}
    </h3>
    <x-box>
        <div class="flex gap-2">
            <div class="grow">
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
            @if (!auth()->user()->subscribed('kanka') || auth()->user()->subscription('kanka')->canceled())
            <div class="flex-0">
                    <x-buttons.confirm outline="true" type="danger" target="delete-account">
                        <i class="fa-solid fa-exclamation-triangle" aria-hidden="true"></i>
                        <span>{{ __('profiles.sections.delete.delete') }}</span>
                    </x-buttons.confirm>
            </div>
            @endif
        </div>
    </x-box>
@endsection

@section('modals')
    @parent
    <x-dialog id="delete-account" :title="__('profiles.sections.delete.title')">
        <p class="mb-2">
            {{ __('profiles.sections.delete.helper') }}
        </p>
        <p class="mb-2">
            {{ __('profiles.sections.delete.warning') }}
        </p>

        {!! Form::model($user, ['method' => 'PATCH', 'route' => ['settings.account.destroy'], 'class' => 'w-full']) !!}
        <div class="">
            <p>
                {!! __('profiles.sections.delete.goodbye', ['code' => '<code>goodbye</code>']) !!}
            </p>
            <div class="form-group required">
                {!! Form::text('goodbye',null, ['class' => 'form-control','required']) !!}
            </div>
            <x-buttons.confirm type="danger" outline="true" full="true">
                <i class="fa-solid fa-exclamation-triangle" aria-hidden="true"></i>
                {{ __('profiles.sections.delete.confirm') }}
            </x-buttons.confirm>
        </div>
        {!! Form::close() !!}
    </x-dialog>
@endsection
