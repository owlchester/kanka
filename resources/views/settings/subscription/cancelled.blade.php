<?php /**
 * @var \App\Models\CampaignBoost $boost
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\User $user
 */

?>
@extends('layouts.app', [
    'title' => __('subscriptions/cancelled.seo_title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'centered' => true,
])

@section('content')

    <x-hero>
        <x-slot name="title">
            💔
            {!! __('subscriptions/cancelled.title', ['name' => $user->name]) !!}
        </x-slot>
        <x-slot name="subtitle">{{ __('subscriptions/cancelled.subtitle') }}</x-slot>
    </x-hero>

    <x-grid type="1/1">
        <x-box class="flex flex-col gap-4">
                <div class="text-xl">
                    ⏳
                    {{ __('subscriptions/cancelled.active.title') }}
                </div>
                <p>
                    {!! __('subscriptions/cancelled.active.helper', [
    'date' => '<strong>' . $endDate . '</strong>'
]) !!}
                </p>
            <ul>
                <li>{!! __('subscriptions/cancelled.active.premium' ) !!}</li>
                <li>{!! __('subscriptions/cancelled.active.discord', ['discord' => '<a href="' . \App\Facades\Domain::toFront('go/discord') . '" class="text-link">Discord</a>'] ) !!}</li>
                <li>{!! __('subscriptions/cancelled.active.adfree' ) !!}</li>
                <li>{!! __('subscriptions/cancelled.active.limit' ) !!}</li>
                <li>{!! __('subscriptions/cancelled.active.more' ) !!}</li>
            </ul>
        </x-box>

        <x-box class="flex flex-col gap-4">
                <div class="text-xl">
                    ❌
                    {{ __('subscriptions/cancelled.next.title') }}
                </div>
                <p>{!! __('subscriptions/cancelled.next.helper', [
]) !!}</p>
            <ul>
                <li>{!! __('subscriptions/cancelled.next.premium' ) !!}</li>
                <li>{!! __('subscriptions/cancelled.next.discord', ['discord' => '<a href="' . \App\Facades\Domain::toFront('go/discord') . '" class="text-link">Discord</a>'] ) !!}</li>
                <li>{!! __('subscriptions/cancelled.next.data' ) !!}</li>
            </ul>
        </x-box>

        <x-box class="flex flex-col gap-4">
                <div class="text-xl">
                    💡
                    {{ __('subscriptions/cancelled.change.title') }}
                </div>
                <p>{!! __('subscriptions/cancelled.change.helper', [
]) !!}</p>
            <p>
                <a href="{{ route('settings.subscription') }}" class="btn2 btn-primary btn-sm">
                    {{ __('subscriptions/cancelled.change.action') }}
                </a>
            </p>
        </x-box>

        <x-box class="flex flex-col gap-4">
            <div class="text-xl">
                👋
                {{ __('subscriptions/cancelled.contact.title') }}
            </div>
            <p>{!! __('subscriptions/cancelled.contact.helper', []) !!}</p>
            <p>
                {!! __('subscriptions/cancelled.contact.feedback', []) !!}
                <a href="{{ \App\Facades\Domain::toFront('contact') }}" class="text-link">
                    {{ __('subscriptions/cancelled.contact.send') }}
                </a>
            </p>
        </x-box>
    </x-grid>
@endsection



@section('scripts')
    @parent
    @vite('resources/js/subscription.js')
@endsection

@section('styles')
    @vite('resources/css/subscription.css')
@endsection
