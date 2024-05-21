<?php /** @var \App\User $user */?>
@extends('layouts.app', [
    'title' => __('settings.account.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'centered' => true,
])

@section('content')
    <x-grid type="1/1">
    @include('partials.errors')

    <h1 class="">
        {{ __('settings.account.email') }}
    </h1>
    {!! Form::model($user, ['method' => 'PATCH', 'route' => ['settings.account.email']]) !!}
        <x-grid type="1/1">
            <x-forms.field field="email" :required="true" :label="__('profiles.fields.email')">
                {!! Form::email('email', null, ['placeholder' => __('profiles.placeholders.email'), 'class' => '']) !!}
            </x-forms.field>

            <div class="text-right">
                <x-buttons.confirm type="primary">
                    {{ __('settings.account.actions.update_email') }}
                </x-buttons.confirm>
            </div>
        </x-grid>
    {!! Form::close() !!}

    <hr />

    @if (!$user->isSocialLogin())
        <h3 class="">
            {{ __('settings.account.password') }}
        </h3>
        {!! Form::model($user, ['method' => 'PATCH', 'route' => ['settings.account.password']]) !!}

        <x-grid type="1/1">
            <x-forms.field field="new-password" :required="true" :label="__('profiles.fields.new_password')">
                {!! Form::password('password_new', ['placeholder' => __('profiles.placeholders.new_password'), 'class' => '']) !!}
            </x-forms.field>
            <x-forms.field field="password-confirm" :required="true" :label="__('profiles.fields.new_password_confirmation')">
                {!! Form::password('password_new_confirmation', ['placeholder' => __('profiles.placeholders.new_password_confirmation'), 'class' => '']) !!}
            </x-forms.field>

            <div class="text-right">
                <x-buttons.confirm type="primary">
                    {{ __('settings.account.actions.update_password') }}
                </x-buttons.confirm>
            </div>
        </x-grid>
        {!! Form::close() !!}

        <hr />
    @else
        <h2 >
            {{ __('settings.account.social.title') }}
        </h2>
        {!! Form::model($user, ['method' => 'PATCH', 'route' => ['settings.account.social']]) !!}
        <x-grid type="1/1">
            <p class="help">{{ __('settings.account.social.helper', ['provider' => ucfirst($user->provider)]) }}</p>
            <x-forms.field field="new-password" :label="__('profiles.fields.new_password')">
                {!! Form::password('password_new', ['placeholder' => __('profiles.placeholders.new_password'), 'class' => '']) !!}
            </x-forms.field>

            <div class="text-right">
                <x-buttons.confirm type="primary">
                    {{ __('settings.account.actions.social') }}
                </x-buttons.confirm>
            </div>
        </x-grid>
        {!! Form::close() !!}

        <hr />
    @endif

    @includeWhen(config('google2fa.enabled'), 'settings._tfa')

    <h3 class="text-error">
        {{ __('profiles.sections.dangerzone') }}
    </h3>
    <div class="flex gap-2">
        <div class="grow">
            <strong>
                {{ __('profiles.sections.delete.title') }}
            </strong><br />
            <p>{{ __('profiles.sections.delete.helper') }}</p>

            @if (auth()->user()->subscribed('kanka') && !auth()->user()->subscription('kanka')->canceled())
                <p class="text-error">
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
    </x-grid>
@endsection

@section('modals')
    @parent
    <x-dialog id="delete-account" :title="__('profiles.sections.delete.title')">
        <p class="">
            {{ __('profiles.sections.delete.helper') }}
        </p>
        <p class="">
            {{ __('profiles.sections.delete.warning') }}
        </p>

        {!! Form::model($user, ['method' => 'PATCH', 'route' => ['settings.account.destroy'], 'class' => 'w-full']) !!}
        <x-grid type="1/1">
            <p>
                {!! __('profiles.sections.delete.goodbye', ['code' => '<code>goodbye</code>']) !!}
            </p>
            <x-forms.field field="goodbye" :required="true">
                {!! Form::text('goodbye',null, ['class' => '','required']) !!}
            </x-forms.field>
            <x-buttons.confirm type="danger" outline="true" full="true">
                <i class="fa-solid fa-exclamation-triangle" aria-hidden="true"></i>
                {{ __('profiles.sections.delete.confirm') }}
            </x-buttons.confirm>
        </x-grid>
        {!! Form::close() !!}
    </x-dialog>
@endsection
