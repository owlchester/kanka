@extends('layouts.app', [
    'title' => __('referrals.title'),
    'description' => '',
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'centered' => true,
])

@section('content')
    <x-hero>
        <x-slot name="title">{{ __('referrals.title') }}</x-slot>
        <x-slot name="subtitle">{{ __('referrals.benefits') }}</x-slot>
    </x-hero>

    <x-grid type="1/1">
        @include('partials.errors')

        <x-box>
            {{ __('referrals.fields.link') }}<br />

            <div class="flex gap-4 items-center">
                <a
                    href="{{ route('referrals', $referral) }}"
                    class="text-link">
                    {{ route('referrals', $referral) }}
                </a>

                <span
                    class="btn2 btn-xs btn-outline"
                    role="button"
                    data-clipboard="{{ route('referrals', $referral) }}"
                    data-toast="{{ __('referrals.toasts.copied') }}">
                    <x-icon class="copy"></x-icon>
                    {{ __('referrals.actions.copy') }}
                </span>
            </div>
        </x-box>

        <x-box>
            @if (empty($users))
                <x-helper>
                    <p>{{ __('referrals.stats.empty') }}</p>
                </x-helper>
            @else
            <div class="flex flex-col gap-2">
                <p>{{ __('referrals.stats.invited') }} {{ trans_choice('referrals.stats.users', $users, ['amount' => $users]) }}</p>
                <p>{{ __('referrals.stats.subscribers', ['amount' => $subscribers]) }}</p>
                <p>{{ __('referrals.stats.badge', ['level' => $badge]) }}</p>
            </div>
            @endif
        </x-box>
    </x-grid>
@endsection
