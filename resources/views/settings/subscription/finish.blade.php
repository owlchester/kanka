<?php /**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\User $user
 */

?>
@extends('layouts.app', [
    'title' => __('subscriptions/finish.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'centered' => true,
])

@section('content')
    <x-hero>
        <x-slot name="title">
            {{ $isTrial ? __('subscriptions/free-trial.started.title') : __('subscriptions/finish.title') }}
        </x-slot>
        <x-slot name="subtitle">
            {{ $isTrial ? __('subscriptions/free-trial.started.header') : __('subscriptions/finish.header') }}
        </x-slot>
    </x-hero>
    <x-grid type="1/1">
        <p>{{ __('subscriptions/finish.next') }}</p>

        <div id="premium" class="flex flex-col gap-4 bg-box p-4 rounded-2xl">
            <h2 class="text-2xl">
                <x-icon class="premium" />
                {{ __('subscriptions/finish.premium.title') }}
            </h2>
            <p>{!! __('subscriptions/finish.premium.helper', [
    'plugins' => '<a href="' . config('marketplace.url') . '">' . __('footer.plugins') . '</a>'
]) !!}</p>
            <div class="flex flex-col gap-4">
                @foreach ($availableCampaigns as $availableCampaign)
                    <div id="campaign-{{ $availableCampaign->id }}" class="flex gap-4 border border-base-200 shadow-xs hover:shadow-md rounded-2xl px-4 py-2 items-center">
                        @if ($availableCampaign->image)
                            <img src="{{ $availableCampaign->thumbnail(320, 240) }}" alt="{{ $availableCampaign->name }}" loading="lazy" class="rounded-full w-12 h-12" />
                        @else
                            <img src="https://th.kanka.io/zzKcBpijSBvm4rPWdzRpI82pTNQ=/320x240/smart/src/app/backgrounds/mountain-background-medium.jpg" alt="{{ $availableCampaign->name }}" loading="lazy" class="rounded-full w-12 h-12" />
                        @endif

                        <div class="flex gap-4 w-full items-center justify-between">
                            <div class="flex flex-col gap-1">
                                <a class="text-xl" href="{{ route('dashboard', [$availableCampaign]) }}">
                                    {!! $availableCampaign->name !!}
                                </a>
                                <x-helper>
                                    <p>{{ __('settings/boosters.campaign.standard') }}</p>
                                </x-helper>
                            </div>
                            <a href="#" data-toggle="dialog" data-url="{{ route('campaign_boosts.create', ['campaign' => $availableCampaign, 'next' => 'subscription.finish']) }}" class="btn2 btn-outline btn-sm">
                                <x-icon class="premium" />
                                {!! __('settings/premium.actions.unlock') !!}
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>

        <div id="discord" class="flex flex-col gap-4 bg-box p-4 rounded-2xl">
            <h2 class="text-2xl">
                <x-icon class="fa-brands fa-discord" />
                {{ __('subscriptions/finish.discord.title') }}
            </h2>
            <p>{!! __('subscriptions/finish.discord.helper', [
]) !!}</p>
            <p>
            @if (!$user->discord())
                <a href="{{ route('settings.apps') }}">
                    {{ __('subscriptions/finish.discord.action') }}
                </a>
            @else
                <a href="{{ \App\Facades\Domain::toFront('go/discord') }}">
                    {{ __('subscriptions/finish.discord.enjoy') }}
                </a>
            @endif
            </p>
        </div>

        <div id="roadmap" class="flex flex-col gap-4 bg-box p-4 rounded-2xl">
            <h2 class="text-2xl">
                <x-icon class="fa-regular fa-box-ballot" />
                {{ __('subscriptions/finish.roadmap.title') }}
            </h2>
            <p>{!! __('subscriptions/finish.roadmap.helper', [
]) !!}</p>
            <p>
            <a href="{{ route('roadmap') }}">
                {{ __('subscriptions/finish.roadmap.action') }}
            </a>
            </p>
        </div>

        <div id="help" class="flex flex-col gap-4">
            <h2 class="text-2xl">
                {{ __('subscriptions/finish.help.title') }}
            </h2>
            <p>{!! __('subscriptions/finish.help.helper', [
    'contact-us' => '<a href="' . \App\Facades\Domain::toFront('contact') . '">' . __('subscriptions/finish.help.contact-us') . '</a>',
    'docs' => '<a href="https://docs.kanka.io">' . __('footer.documentation') . '</a>'
]) !!}</p>
        </div>
    </x-grid>
@endsection



@section('scripts')
    @parent
    @vite('resources/js/subscription.js')

@if($tracking == 'subscribed')
    <script>
        gtag('event', 'conversion', {
            'send_to': 'AW-659212134/z5nbCLmq0fsBEOaOq7oC',
            'transaction_id': '{{ auth()->user()->id }}'
        });
    </script>
@endif
@endsection

@section('styles')
    @vite('resources/css/subscription.css')
@endsection
