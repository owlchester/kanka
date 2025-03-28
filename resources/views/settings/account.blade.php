<?php /** @var \App\Models\User $user */?>
@extends('layouts.app', [
    'title' => __('settings.account.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'centered' => true,
])

@section('content')

    <x-box class="mb-12 rounded-2xl">
        <x-slot name="title">
            {{ __('settings/account.title') }}
        </x-slot>
        <div class="flex flex-col gap-4">
            <div class="flex gap-2 items-center flex-wrap">
                <div class="w-40 font-extrabold">
                    {{ __('auth.login.fields.email') }}
                </div>
                <div class="grow">
                    {{ auth()->user()->email }}
                </div>
                <div class="flex-none">
                    <button class="btn2 btn-outline" data-toggle="dialog" data-target="primary-dialog" data-url="{{  route('account.email') }}">
                        {{ __('account/email.actions.update') }}
                    </button>
                </div>
            </div>
            <hr />
            <div class="flex gap-2 items-center flex-wrap">
                <div class="w-40 font-extrabold">
                    {{ __('auth.login.fields.password') }}
                </div>
                @if (!$user->isSocialLogin())
                <div class="grow">
                    *********
                </div>
                <div class="flex-none">
                    <button class="btn2 btn-outline" data-toggle="dialog" data-target="primary-dialog" data-url="{{  route('account.password') }}">
                        {{ __('account/password.actions.update') }}
                    </button>
                </div>
                @else
                    <div class="grow">
                        {!! __('account/social.info', ['provider' => '<strong>' . ucfirst($user->provider ?? 'debug') . '</strong>']) !!}
                    </div>
                    <div class="flex-none">
                        <button class="btn2 btn-outline" data-toggle="dialog" data-target="primary-dialog" data-url="{{  route('account.social') }}">
                            {{ __('settings.account.actions.social') }}
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </x-box>

    @includeWhen(config('google2fa.enabled'), 'settings._tfa')

    <x-box class="border-error border rounded-2xl">
        <x-slot name="title">
            <span class="text-error">{{ __('profiles.sections.dangerzone') }}</span>
        </x-slot>

        <div class="flex flex-col md:flex-row gap-4 md:justify-between">
            <div class="flex flex-col gap-4">
                <p>{{ __('profiles.sections.delete.helper') }}</p>

                @if (auth()->user()->subscribed('kanka') && !auth()->user()->subscription('kanka')->canceled())
                    <p>
                        {!! __('profiles.sections.delete.subscribed', [
        'subscription' => '<a href="' . route('settings.subscription') . '">' . __('settings.menu.subscription') . '</a>'
    ]) !!}
                    </p>
                @endif
                @if (!auth()->user()->subscribed('kanka') || auth()->user()->subscription('kanka')->canceled())
                    <div class="flex justify-end">
                    <x-buttons.confirm type="danger" target="delete-account">
                        <x-icon class="fa-solid fa-exclamation-triangle" />
                        <span>{{ __('profiles.sections.delete.delete') }}</span>
                    </x-buttons.confirm>
                    </div>
                @endif
            </div>
        </div>
    </x-box>

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

        <x-form :action="['settings.account.destroy']" method="PATCH" class="w-full">
            <x-grid type="1/1">
                <p>
                    {!! __('profiles.sections.delete.goodbye', ['code' => '<code>goodbye</code>']) !!}
                </p>
                <x-forms.field field="goodbye" required>
                    <input type="text" name="goodbye" @if (config('app.debug')) value="goodbye" @endif required  />
                </x-forms.field>
                <x-buttons.confirm type="danger" full="true">
                    <x-icon class="fa-solid fa-exclamation-triangle" />
                    {{ __('profiles.sections.delete.confirm') }}
                </x-buttons.confirm>
            </x-grid>
        </x-form>
    </x-dialog>
@endsection
