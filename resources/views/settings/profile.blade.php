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
                <div class="relative shrink-0" data-profile-avatar>
                    <button type="button" data-dropdown aria-label="{{ __('settings.profile.avatar_menu') }}" aria-haspopup="menu" class="flex flex-col items-center gap-1 rounded-xl focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 cursor-pointer">
                        <img data-avatar-image data-has-avatar="{{ $user->hasAvatar() ? 'true' : 'false' }}" class="size-24 rounded-xl bg-base-300 object-cover p-3" src="{{ $user->hasAvatar() ? $user->getAvatarUrl(200) : asset('/images/defaults/avatar.svg') }}" width="96" height="96" alt="{{ __('settings.profile.avatar_alt') }}">
                        @unless ($user->hasAvatar())
                            <span data-profile-avatar-prompt class="text-xs text-link">{{ __('settings.profile.add_photo') }}</span>
                        @endunless
                    </button>
                    <div class="dropdown-menu hidden" role="menu">
                        <button type="button" role="menuitem" data-avatar-select class="w-full rounded-xl px-2 py-2 text-left text-xs hover:bg-base-200">{{ __('settings.profile.select_image') }}</button>
                        <button type="button" role="menuitem" data-avatar-remove class="w-full rounded-xl px-2 py-2 text-left text-xs hover:bg-base-200 {{ $user->hasAvatar() ? '' : 'hidden' }}">{{ __('settings.profile.remove_image') }}</button>
                    </div>
                    <input type="file" data-avatar-input accept="image/jpeg,image/png,image/gif,image/webp" class="hidden">
                    <input type="hidden" data-avatar-upload-url value="{{ route('settings.profile.avatar-upload') }}">
                    <input type="hidden" data-avatar-remove-url value="{{ route('settings.profile.avatar-remove') }}">
                    <input type="hidden" data-avatar-placeholder value="{{ asset('/images/defaults/avatar.svg') }}">
                </div>
                <div class="grow flex flex-col gap-5">
                    <x-forms.field field="name" :label="__('profiles.fields.name')" required>
                        <input type="text" name="name" maxlength="191" placeholder="{{ __('profiles.placeholders.name') }}" class="rounded border p-2 w-full" value="{{ old('name', $user->name ?? null) }}" />
                    </x-forms.field>

                    @php $helper =  __('profiles.helpers.profile-name', [
    'marketplace' => '<a href="' . config('marketplace.url') . '" class="text-link">' . __('footer.plugins'). '</a>',
    'profile' => '<a href="' . route('users.profile', $user) . '" class="text-link">' . __('profiles.settings.helpers.profile') . '</a>']) @endphp
                    <x-forms.field field="marketplace-name" :label="__('profiles.fields.profile-name')" :helper="$helper">
                        <input type="text" name="settings[marketplace_name]" maxlength="32" placeholder="{{ __('profiles.fields.profile-name') }}" class="rounded border p-2 w-full" value="{{ old('settings[marketplace_name]', $user->settings['marketplace_name'] ?? null) }}" />
                    </x-forms.field>

                    @php $helper =  __('profiles.helpers.pronouns', [
                        'marketplace' => '<a href="' . config('marketplace.url') . '" class="text-link">' . __('footer.plugins'). '</a>',
                        'profile' => '<a href="' . route('users.profile', $user) . '" class="text-link">' . __('profiles.settings.helpers.profile') . '</a>'])
                    @endphp
                    <x-forms.field field="pronouns" :label="__('profiles.fields.pronouns')" :helper="$helper">
                        <input type="text" name="settings[pronouns]" maxlength="45" placeholder="{{ __('profiles.fields.pronouns') }}" class="rounded border p-2 w-full" value="{{ old('settings[pronouns]', $user->settings['pronouns'] ?? null) }}" />
                    </x-forms.field>

                    @php $helper = __('profiles.settings.helpers.bio', [
    'link' => '<a href="' . route('users.profile', $user) . '" class="text-link">' . __('profiles.settings.helpers.profile') . '</a>'
    ]); @endphp
                    <x-forms.field field="bio" :label="__('profiles.fields.bio')" :helper="$helper">
                        <textarea name="profile[bio]" placeholder="{{ __('profiles.placeholders.bio') }}" class="w-full rounded border p-2" rows="5" maxlength="300">{{ old('profile[bio]', \Illuminate\Support\Arr::get($user->profile, 'bio')) }}</textarea>
                    </x-forms.field>

                    @php $helper =  __('profiles.helpers.link', [
                        'marketplace' => '<a href="' . config('marketplace.url') . '" class="text-link">' . __('footer.plugins'). '</a>',
                        'profile' => '<a href="' . route('users.profile', $user) . '"  class="text-link">' . __('profiles.settings.helpers.profile') . '</a>'])
                    @endphp
                    <x-forms.field field="link" :label="__('profiles.fields.link')" :helper="$helper">
                        <input type="text" name="settings[link]" maxlength="90" placeholder="{{ __('profiles.fields.link') }}" class="rounded border p-2 w-full" value="{{ old('settings[link]', $user->settings['link'] ?? null) }}" />
                    </x-forms.field>

                    <x-forms.field field="share-login" :label="__('profiles.fields.login_sharing')">
                        <div class="flex flex-col gap-2">
                            <div class="rounded-xl border border-base-300 p-2 flex gap-2 items-start cursor-pointer hover:shadow-sm">
                                <input type="radio" name="has_last_login_sharing" id="last-login-sharing-yes" value="1" class="mt-1" @if (old('has_last_login_sharing', $user->has_last_login_sharing ?? false)) checked="checked" @endif />
                                <label for="last-login-sharing-yes" class="w-full cursor-pointer">{{ __('profiles.options.share_last_login') }}</label>
                            </div>
                            <div class="rounded-xl border border-base-300 p-2 flex gap-2 items-start cursor-pointer hover:shadow-sm">
                                <input type="radio" name="has_last_login_sharing" id="last-login-sharing-no" value="0" class="mt-1" @if (!old('has_last_login_sharing', $user->has_last_login_sharing ?? false)) checked="checked" @endif />
                                <label for="last-login-sharing-no" class="w-full cursor-pointer">{{ __('profiles.options.dont_share_last_login') }}</label>
                            </div>
                        </div>
                    </x-forms.field>

                    @if (auth()->user()->isSubscriber())
                        <x-forms.field field="hide-sub" :label="__('profiles.fields.subscription_hiding')">
                            <div class="flex flex-col gap-2">
                                <div class="rounded-xl border border-base-300 p-2 flex gap-2 items-start cursor-pointer hover:shadow-sm">
                                    <input type="radio" name="settings[hide_subscription]" id="hide-subscription-yes" value="1" class="mt-1" @if (old('settings.hide_subscription', $user->settings['hide_subscription'] ?? false)) checked="checked" @endif />
                                    <label for="hide-subscription-yes" class="w-full cursor-pointer">{{ __('profiles.options.hide_subscription') }}</label>
                                </div>
                                <div class="rounded-xl border border-base-300 p-2 flex gap-2 items-start cursor-pointer hover:shadow-sm">
                                    <input type="radio" name="settings[hide_subscription]" id="hide-subscription-no" value="0" class="mt-1" @if (!old('settings.hide_subscription', $user->settings['hide_subscription'] ?? false)) checked="checked" @endif />
                                    <label for="hide-subscription-no" class="w-full cursor-pointer">{{ __('profiles.options.show_subscription') }}</label>
                                </div>
                            </div>
                        </x-forms.field>
                    @endif
                </div>
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
                <div class="flex flex-col gap-4">
                <p>This will reset all tutorials, and make all the dismissible helper texts reappear.</p>
                <x-form :action="['tutorials.reset']" method="PATCH">
                    <x-buttons.confirm type="danger" outline>
                        <x-icon class="trash" />
                        Reset all tutorials
                    </x-buttons.confirm>
                </x-form>
                </div>
            </x-box>
        @endif
@endsection

@section('scripts')
    @parent
    @vite('resources/js/profile.js')
@endsection
