<?php /** @var \App\User $user */?>
@extends('layouts.app', [
    'title' => __('settings.profile.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'noads' => true,
    'centered' => true,
])

@section('content')
    <x-grid type="1/1">
        @include('partials.errors')
        <h1 class="">
            {{ __('settings.profile.title') }}
        </h1>

        {!! Form::model($user, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'route' => ['settings.profile'], 'data-shortcut' => 1]) !!}
            <div class="flex flex-col md:flex-row gap-5">
                <div class="grow flex flex-col gap-5">
                    <x-forms.field field="name" :label="__('profiles.fields.name')" :required="true">
                        {!! Form::text('name', null, ['placeholder' => __('profiles.placeholders.name'), 'class' => 'rounded border p-2 w-full']) !!}
                    </x-forms.field>

                    @php $helper =  __('profiles.helpers.profile-name', [
    'marketplace' => link_to(config('marketplace.url'), __('footer.marketplace'), ['target' => '_blank']),
    'profile' => link_to_route('users.profile', __('profiles.settings.helpers.profile'), $user, ['target' => '_blank'])]) @endphp
                    <x-forms.field field="marketplace-name" :label="__('profiles.fields.profile-name')" :helper="$helper">
                        {!! Form::text('settings[marketplace_name]', null, ['class' => 'rounded border p-2 w-full', 'maxlength' => 32]) !!}
                    </x-forms.field>

                    <x-forms.field field="bio" :label="__('profiles.fields.bio')" :helper="__('profiles.settings.helpers.bio', [
    'link' => link_to_route('users.profile', __('profiles.settings.helpers.profile'), $user, ['target' => '_blank'])
    ])">
                        {!! Form::textarea('profile[bio]', null, ['placeholder' => __('profiles.placeholders.bio'), 'class' => 'rounded border p-2 w-full', 'rows' => 5, 'maxlength' => 300]) !!}
                    </x-forms.field>

                    <x-forms.field field="share-login" :label="__('profiles.fields.login_sharing')">
                    {!! Form::hidden('has_last_login_sharing', 0) !!}
                        <label class="text-neutral-content cursor-pointer flex gap-2">
                            {!! Form::checkbox('has_last_login_sharing') !!}
                            {{ __('profiles.fields.last_login_share') }}
                        </label>
                    </x-forms.field>

                    @if (auth()->user()->isSubscriber())
                        <x-forms.field field="hide-sub" :label="__('profiles.fields.subscription_hiding')">
                            {!! Form::hidden('settings[hide_subscription]', 0) !!}
                            <label class="text-neutral-content cursor-pointer flex gap-2">
                                {!! Form::checkbox('settings[hide_subscription]', 1) !!}
                                {!! __('profiles.fields.hide_subscription', [
    'hall_of_fame' => link_to('https://kanka.io/hall-of-fame', __('front/hall-of-fame.title'), null, ['target' => '_blank'])
    ]) !!}
                            </label>
                        </x-forms.field>
                    @endif
                </div>
                <x-forms.field field="avatar" :label="__('settings.profile.avatar')">
                    {!! Form::file('avatar', ['class' => 'image']) !!}

                    @if (!empty(auth()->user()->avatar) && auth()->user()->avatar != 'users/default.png')
                        <div class="rounded-full">
                            <img class="avatar rounded-full avatar-user" src="{{ auth()->user()->getAvatarUrl(200) }}" width="200" height="200" alt="{{ auth()->user()->name }}">
                        </div>

                    @endif

                </x-forms.field>
            </div>
            <div class="text-right">
                <x-buttons.confirm type="primary">
                    {{ __('settings.profile.actions.update_profile') }}
                </x-buttons.confirm>
            </div>
        {!! Form::close() !!}
        @if (!app()->isProduction())
            {!! Form::model($user, ['method' => 'PATCH', 'enctype' => 'multipart/form-data', 'route' => ['tutorials.reset']]) !!}
            <div class="flex gap-2 my-5">
                <h1 class="grow">
                    Reset Tutorials
                </h1>
                <x-buttons.confirm type="danger" outline="true">
                    Reset tutorials
                </x-buttons.confirm>
            </div>
            {!! Form::close() !!}
        @endif
    </x-grid>
@endsection
