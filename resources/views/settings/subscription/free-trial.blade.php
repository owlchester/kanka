<?php /**
 * @var \App\Models\User $user
 */

?>
@extends('layouts.app', [
    'title' => __('subscriptions/free-trial.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'centered' => true,
    'skipBanners' => true
])

@section('content')
    <x-hero>
        <x-slot name="title">{{ __('subscriptions/free-trial.title') }}</x-slot>
        <x-slot name="subtitle">{!! __('subscriptions/free-trial.header', [
    'what' => '<strong>' . __('subscriptions/free-trial.what', [
        'amount' => 15,
        'tier' => 'Owlbear'
]) . '</strong>'
]) !!}</x-slot>
        <x-form method="POST" :action="['settings.free-trial.accept']">
        <button type="submit" class="btn2 btn-primary mt-4 mb-1">
            <x-icon class="fa-regular fa-gift" />
            {{ __('subscriptions/free-trial.actions.accept') }}
        </button>
        <x-helper class="text-xs">
            {{ __('subscriptions/free-trial.actions.magic') }}
        </x-helper>
        </x-form>
    </x-hero>

    <x-grid type="1/1">
        <div id="included" class="flex flex-col gap-4 bg-box p-4 rounded-2xl">
            <h2>
                <x-icon class="fa-regular fa-check-square" />
                {{ __('subscriptions/free-trial.included.title') }}
            </h2>

            <div class="flex flex-col gap-1 w-fit">
            @include('settings.subscription.tiers.benefits._owlbear')
            </div>

            <p>
                {!! __('subscriptions/free-trial.included.upsell.pitch', [
    'tier' => 'Owlbear',
]) !!}
                <a href="{{ route('settings.subscription') }}">
                    {{ __('subscriptions/free-trial.included.upsell.action') }}
                </a>

            </p>
        </div>

        <div id="why" class="flex flex-col gap-4 bg-box p-4 rounded-2xl">
            <h2>
                <x-icon class="fa-regular fa-trophy" />
                {{ __('subscriptions/free-trial.why.title') }}
            </h2>
            <p>{!! __('subscriptions/free-trial.why.helper', [
    'plugins' => '<a href="' . config('marketplace.url') . '">' . __('footer.plugins') . '</a>'
]) !!}</p>
        </div>


        <div id="tease" class="flex flex-col gap-4 bg-box p-4 rounded-2xl">
            <h2>
                <x-icon class="fa-regular fa-mountain" />
                {{ __('subscriptions/free-trial.tease.title') }}
            </h2>
            <p>{!! __('subscriptions/free-trial.tease.helper', [
    'subscription' => '<a href="' . route('settings.subscription') . '">' . __('billing/menu.overview') . '</a>'
]) !!}</p>
        </div>

        <x-form method="POST" :action="['settings.free-trial.accept']">
        <div class="flex flex-col gap-2">
            <p>
                <button type="submit" class="btn2 btn-primary mt-4 mb-1">
                    <x-icon class="fa-regular fa-gift" />
                    {{ __('subscriptions/free-trial.final.title') }}
                </button>
            </p>
            <x-helper class="text-xs">
                {{ __('subscriptions/free-trial.final.magic') }}
            </x-helper>
        </div>
        </x-form>

    </x-grid>
@endsection


@section('scripts')
    @parent
    @vite('resources/js/subscription.js')
@endsection

@section('styles')
    @vite('resources/sass/subscription.scss')
@endsection
