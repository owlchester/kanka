<?php /**
 * @var \App\Models\CampaignBoost $boost
 * @var \App\Models\Campaign $campaign
 * @var \App\Services\SubscriptionService $service
 * @var \App\User $user
 */

?>
@extends('layouts.app', [
    'title' => __('settings.subscription.manage_subscription'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
])

@section('content')
    <h1 class="mb-3">{{ __('settings.subscription.manage_subscription') }}</h1>

    <p class="text-lg">
        {!! __('subscription.benefits.main', [
            'more' => link_to_route('front.pricing', __('subscription.benefits.more'), '#paid-features', ['target' => '_blank']),
            'boosters' => link_to_route('front.premium', __('concept.premium-campaigns'), '', ['target' => '_blank']),
            'stripe' => link_to('https://www.stripe.com', 'Stripe', ['target' => '_blank'])
        ]) !!}
    </p>

    @include('partials.errors')
    @if (session('sub_value'))
        <div class="text-center">
            <p>
                <a  href="{{ route('settings.premium') }}" class="btn btn-primary btn-lg mr-4" target="blank">
                    <i class="fa-solid fa-rocket mr-1" aria-hidden="true"></i>
                    {{ __('settings/premium.ready.title') }}
                </a>
                @if (!$user->discord())
                    <a  href="{{ route('settings.apps') }}" class="btn btn-primary btn-lg ml-4" target="blank">
                        <i class="fa-brands fa-discord mr-1" aria-hidden="true"></i>
                        {{ __('settings.apps.discord.unlock') }}
                    </a>
                @endif
            </p>
        </div>
    @endif
    @include('settings.subscription._recap')

    <div class="flex gap-2 mb-2">
        <h2 class="grow">
            {{ __('settings.subscription.tiers') }}
        </h2>
        <x-buttons.confirm type="ghost" target="change-information" size="sm">
            <x-icon class="question"></x-icon>
            <span>{{ __('settings.subscription.upgrade_downgrade.button') }}</span>
        </x-buttons.confirm>
    </div>
    <div class="rounded bg-box period-month" id="pricing-overview">
        <div class="text-center py-5 text-vertical">
            <span>{{ __('tiers.periods.monthly') }}</span>
            <label class="toggle mx-1">
                <input type="checkbox" name="period">
                <span class="slider subscription-period-slider"></span>
            </label>
            <span>{{ __('tiers.toggle.yearly') }}</span>
        </div>

        <table class="table table-bordered tiers">
            <thead>
            <tr class="">
                <th class="align-middle">
                    <div class="tier">
                        <div class="img">
                            <img class="img-circle" src="https://kanka-app-assets.s3.amazonaws.com/images/tiers/kobold-325.png" alt="Kobold"/>
                        </div>
                        <div class="text">
                            KOBOLD
                            <span class="price">
                                {{ __('front.features.patreon.free') }}
                            </span>
                        </div>
                    </div>
                </th>
                <th class="align-middle">
                    <div class="tier">
                        <div class="img">
                            <img class="img-circle" src="https://kanka-app-assets.s3.amazonaws.com/images/tiers/owlbear-325.png" alt="Owlbear"/>
                        </div>
                        <div class="text">
                            OWLBEAR
                            <div class="price price-monthly">
                                {{ $user->currencySymbol() }} 5<sup>00</sup>
                                <span class="">{{ __('tiers.periods.monthly') }}</span>
                            </div>
                            <div class="price price-yearly">
                                {{ $user->currencySymbol() }} 55<sup>00</sup>
                                <span class="">{{ __('tiers.periods.yearly') }}</span>
                            </div>
                        </div>
                        <div class="ribbon ribbon-top-right">
                            <span>{{ __('tiers.ribbons.popular') }}</span>
                        </div>
                    </div>
                </th>
                <th class="align-middle">
                    <div class="tier">
                        <div class="img">
                            <img class="img-circle" src="https://kanka-app-assets.s3.amazonaws.com/images/tiers/wyvern-325.png" alt="Wyvern"/>
                        </div>
                        <div class="text">
                            WYVERN
                            <div class="price price-monthly">
                                {{ $user->currencySymbol() }} 10<sup>00</sup>
                                <span class="">{{ __('tiers.periods.monthly') }}</span>
                            </div>
                            <div class="price price-yearly">
                                {{ $user->currencySymbol() }} 110<sup>00</sup>
                                <span class="">{{ __('tiers.periods.yearly') }}</span>
                            </div>
                        </div>
                        <div class="ribbon ribbon-top-right ribbon-red">
                            <span>{{ __('tiers.ribbons.best-value') }}</span>
                        </div>
                    </div>
                </th>
                <th class="align-middle">
                    <div class="tier">
                        <div class="img">
                            <img class="img-circle" src="https://kanka-app-assets.s3.amazonaws.com/images/tiers/elemental-325.png" alt="Elemental"/>
                        </div>
                        <div class="text">
                            ELEMENTAL
                            <div class="price price-monthly">
                                {{ $user->currencySymbol() }} 25<sup>00</sup>
                                <span class="">{{ __('tiers.periods.monthly') }}</span>
                            </div>
                            <div class="price price-yearly">
                                {{ $user->currencySymbol() }} 275<sup>00</sup>
                                <span class="">{{ __('tiers.periods.yearly') }}</span>
                            </div>
                        </div>
                    </div>
                </th>
            </tr>
            @if ($user->isLegacyPatron())
                <tr>
                    <td class="text-center" colspan="4">
                        <x-alert type="warning">
                            {!! __('settings.subscription.warnings.patreon', ['patreon' => link_to_route('settings.patreon', __('settings.menu.patreon'))]) !!}
                        </x-alert>
                    </td>
                </tr>
            @elseif($user->hasIncompletePayment('kanka'))
                <tr>
                    <td class="text-center" colspan="4">
                        <x-alert type="warning">
                            {!! __('settings.subscription.warnings.incomplete') !!}
                        </x-alert>
                    </td>
                </tr>
            @else
            <tr class="">
                @include('settings.subscription._buttons', ['toggle' => true])
            </tr>
            @endif
            </thead>
            @include('settings.subscription._benefits')
        </table>
    </div>

    <div class="">
        <p class="help-block">
            {!! __('settings.subscription.trial_period', ['email' => link_to('mailto:' .  config('app.email'), config('app.email'))]) !!}
        </p>
    </div>
    <input type="hidden" id="stripe-token" value="{{ config('services.stripe.key') }}" />
@endsection

@section('modals')
    @parent

    <x-dialog id="change-information" :title="__('settings.subscription.upgrade_downgrade.button')">

        <h4>{{ __('settings.subscription.upgrade_downgrade.upgrade.title') }}</h4>
        <ul class="mb-5">
            @foreach(__('settings.subscription.upgrade_downgrade.upgrade.bullets') as $key => $text)
                <li>{{ $text }}</li>
            @endforeach
        </ul>

        <h4>{{ __('settings.subscription.upgrade_downgrade.downgrade.title') }}</h4>
        <ul class="mb-5">
            @foreach(__('settings.subscription.upgrade_downgrade.downgrade.bullets') as $key => $text)
                <li>{{ $text }}</li>
            @endforeach
        </ul>

        <h4>{{ __('settings.subscription.upgrade_downgrade.cancel.title') }}</h4>
        <ul>
            <li>{{ __('settings.subscription.upgrade_downgrade.cancel.bullets.kobold') }}</li>
            <li>{{ __('settings.subscription.upgrade_downgrade.cancel.bullets.bonuses') }}</li>
            <li>{{ __('settings.subscription.upgrade_downgrade.cancel.bullets.premium') }}</li>
        </ul>
    </x-dialog>

    <div class="modal fade" id="change-currency" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                @if (auth()->user()->subscribed('kanka') || auth()->user()->subscription('kanka')?->ended())
                    @include('partials.forms._modal', [
                        'title' => __('settings.subscription.currency.title'),
                        'content' => 'settings.subscription.currency._blocked',
                        'actions' => '',
                    ])
                @else
                {!! Form::model(auth()->user(), ['method' => 'PATCH', 'route' => ['billing.payment-method.save']]) !!}
                @include('partials.forms._modal', [
                    'title' => __('settings.subscription.currency.title'),
                    'content' => 'settings.subscription.currency._form',
                    'submit' => __('settings.subscription.actions.update_currency')
                ])
                <input type="hidden" name="from" value="{{ 'settings.subscription' }}" />
                {!! Form::close() !!}
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="subscribe-confirm" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content"></div>
        </div>
    </div>
@endsection


@section('scripts')
    @parent
    @vite('resources/js/subscription.js')
    <script src="https://js.stripe.com/v3/"></script>

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
    @vite('resources/sass/subscription.scss')
@endsection
