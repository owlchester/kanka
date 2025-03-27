<?php /** @var \App\Models\User $user */?>
@extends('layouts.app', [
    'title' => __('settings.profile.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'centered' => true,
])

@section('content')
    @include('partials.errors')

    <x-box class="mb-12 rounded-2xl">
        <x-slot name="title">
            {{ __('settings.profile.title') }}
        </x-slot>

        <x-form :action="['settings.profile-process']" method="PATCH" files>
            <div class="flex flex-col md:flex-row gap-5">
                <div class="grow flex flex-col gap-5">
                    <x-forms.field field="name" :label="__('profiles.fields.name')" required>
                        <input type="text" name="name" maxlength="191" placeholder="{{ __('profiles.placeholders.name') }}" class="rounded border p-2 w-full" value="{!! old('name', $user->name ?? null) !!}" />
                    </x-forms.field>

                    @php $helper =  __('profiles.helpers.profile-name', [
    'marketplace' => '<a href="' . config('marketplace.url') . '">' . __('footer.plugins'). '</a>',
    'profile' => '<a href="' . route('users.profile', $user) . '" target="_blank">' . __('profiles.settings.helpers.profile') . '</a>']) @endphp
                    <x-forms.field field="marketplace-name" :label="__('profiles.fields.profile-name')" :helper="$helper">
                        <input type="text" name="settings[marketplace_name]" maxlength="32" placeholder="{{ __('profiles.fields.profile-name') }}" class="rounded border p-2 w-full" value="{!! old('settings[marketplace_name]', $user->settings['marketplace_name'] ?? null) !!}" />
                    </x-forms.field>

                    @php $helper = __('profiles.settings.helpers.bio', [
    'link' => '<a href="' . route('users.profile', $user) . '" target="_blank">' . __('profiles.settings.helpers.profile') . '</a>'
    ]); @endphp
                    <x-forms.field field="bio" :label="__('profiles.fields.bio')" :helper="$helper">
                        <textarea name="profile[bio]" placeholder="{{ __('profiles.placeholders.bio') }}" class="w-full rounded border p-2" rows="5" maxlength="300">{!! old('profile[bio]', \Illuminate\Support\Arr::get($user->profile, 'bio')) !!}</textarea>
                    </x-forms.field>

                    <x-forms.field field="share-login" :label="__('profiles.fields.login_sharing')">
                        <input type="hidden" name="has_last_login_sharing" value="0" />
                        <x-checkbox :text="__('profiles.fields.last_login_share')">
                            <input type="checkbox" name="has_last_login_sharing" value="1" @if (old('has_last_login_sharing', auth()->user()->has_last_login_sharing ?? false)) checked="checked" @endif />
                        </x-checkbox>
                    </x-forms.field>

                    @if (auth()->user()->isSubscriber())
                        <x-forms.field field="hide-sub" :label="__('profiles.fields.subscription_hiding')">
                            <input type="hidden" name="settings[hide_subscription]" value="0" />
                            <x-checkbox :text="__('profiles.fields.hide_subscription', [
    'hall_of_fame' => '<a href=\'https://kanka.io/hall-of-fame\' target=\'_blank\'>' . __('front/hall-of-fame.title') . '</a>',
    ])">
                                <input type="checkbox" name="settings[hide_subscription]" value="1" @if (old('settings[hide_subscription]', auth()->user()->settings['hide_subscription'] ?? false)) checked="checked" @endif />
                            </x-checkbox>
                        </x-forms.field>
                    @endif
                </div>
                <x-forms.field field="avatar" :label="__('settings.profile.avatar')">
                    <input type="file" name="avatar" class="image w-full" id="header_image" accept=".jpg, .jpeg, .png, .gif, .webp, .gif" />

                    @if (!empty(auth()->user()->avatar) && auth()->user()->hasAvatar())
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
        </x-form>
    </x-box>

        @if (!app()->isProduction())
            <x-box class="border-error border rounded-2xl">
                <x-slot name="title">
                    Reset Tutorials
                </x-slot>
                <x-form :action="['tutorials.reset']" method="PATCH">
                    <p>This will reset all tutorials, and make all the dismissible helper texts reappear.</p>
                    <x-buttons.confirm type="danger">
                        Reset all tutorials
                    </x-buttons.confirm>
                </x-form>
            </x-box>
        @endif
@endsection
