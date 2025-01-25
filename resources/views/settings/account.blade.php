<?php /** @var \App\Models\User $user */?>
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
    <x-form :action="['settings.account.email']" method="PATCH">
        <x-grid type="1/1">
            <x-forms.field field="email" required :label="__('profiles.fields.email')">
                <input type="email" name="email" value="{{ old('email', $user->email) }}" placeholder="{{ __('profiles.placeholders.email') }}" autocomplete="email" />
            </x-forms.field>

            <div class="text-right">
                <x-buttons.confirm type="primary">
                    {{ __('settings.account.actions.update_email') }}
                </x-buttons.confirm>
            </div>
        </x-grid>
    </x-form>

    <hr />

    @if (!$user->isSocialLogin())
        <h3 class="">
            {{ __('settings.account.password') }}
        </h3>
        <x-form :action="['settings.account.password']" method="PATCH">
        <x-grid type="1/1">
            <x-helper>
                <p>{{ __('profiles.helpers.new-password') }}</p>
            </x-helper>

            <x-forms.field field="new-password" required :label="__('profiles.fields.new_password')">
                <input type="password" name="password_new" placeholder="{{ __('profiles.placeholders.new_password') }}" autocomplete="new-password" />
            </x-forms.field>
            <x-forms.field field="password-confirm" required :label="__('profiles.fields.new_password_confirmation')">
                <input type="password" name="password_new_confirmation" placeholder="{{ __('profiles.placeholders.new_password_confirmation') }}" autocomplete="new-password" />
            </x-forms.field>


            <div class="text-right">
                <x-buttons.confirm type="primary">
                    {{ __('settings.account.actions.update_password') }}
                </x-buttons.confirm>
            </div>
        </x-grid>
        </x-form>

        <hr />
    @else
        <h2 >
            {{ __('settings.account.social.title') }}
        </h2>
        <x-form :action="['settings.account.social']" method="PATCH">
        <x-grid type="1/1">
            <p class="help">{{ __('settings.account.social.helper', ['provider' => ucfirst($user->provider)]) }}</p>
            <x-forms.field field="new-password" :label="__('profiles.fields.new_password')">
                <input type="password" name="password_new" placeholder="{{ __('profiles.placeholders.new_password') }}" />
            </x-forms.field>

            <div class="text-right">
                <x-buttons.confirm type="primary">
                    {{ __('settings.account.actions.social') }}
                </x-buttons.confirm>
            </div>
        </x-grid>
        </x-form>

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
    'subscription' => '<a href="' . route('settings.subscription') . '">' . __('settings.menu.subscription') . '</a>'
]) !!}
                </p>
            @endif
        </div>
        @if (!auth()->user()->subscribed('kanka') || auth()->user()->subscription('kanka')->canceled())
        <div class="flex-0">
            <x-buttons.confirm outline="true" type="danger" target="delete-account">
                <x-icon class="fa-solid fa-exclamation-triangle" />
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

        <x-form :action="['settings.account.destroy']" method="PATCH">
            <x-grid type="1/1">
                <p>
                    {!! __('profiles.sections.delete.goodbye', ['code' => '<code>goodbye</code>']) !!}
                </p>
                <x-forms.field field="goodbye" required>
                    <input type="text" name="goodbye" @if (config('app.debug')) value="goodbye" @endif required  />
                </x-forms.field>
                <x-buttons.confirm type="danger" outline="true" full="true">
                    <x-icon class="fa-solid fa-exclamation-triangle" />
                    {{ __('profiles.sections.delete.confirm') }}
                </x-buttons.confirm>
            </x-grid>
        </x-form>
    </x-dialog>
@endsection
