<?php /**
 * @var \App\Models\CampaignBoost $boost
 * @var \App\Models\Campaign $campaign
 */
?>
@extends('layouts.app', [
    'title' => __('billing/payment_methods.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
])
@section('content')
    @include('partials.errors')

    <h1 class="mb-3">
        {{ __('billing/payment_methods.title') }}
    </h1>
    <p class="text-lg">
        {!! __('settings.subscription.billing.helper', [
            'stripe' => link_to('https://www.stripe.com', 'Stripe', ['target' => '_blank'])
        ]) !!}
    </p>

    <h3 class="mb-2">
        {{ __('settings.subscription.billing.saved' )}}
    </h3>
    <div id="billing">
        <billing-management
                api_token="{{ $stripeApiToken }}"
                trans="{{ $translations }}"
        ></billing-management>
    </div>


    {!! Form::model(auth()->user(), ['method' => 'PATCH', 'route' => ['billing.payment-method.save']]) !!}
        @if (auth()->user()->subscribed('kanka') || auth()->user()->subscription('kanka')?->ended())
            @include('settings.subscription.currency._blocked')
        @else
            <div class="field-currency mb-5">
                <label>{{ __('settings.subscription.fields.currency') }}</label>
                {!! Form::select('currency', ['' => __('settings.subscription.currencies.usd'), 'eur' => __('settings.subscription.currencies.eur')], auth()->user()->currency(), []) !!}
            </div>
            <div class="text-right">
                <x-buttons.confirm type="primary" outline="true">
                    <x-icon class="save"></x-icon>
                    <span>
                {{ __('settings.subscription.actions.update_currency') }}</span>
                </x-buttons.confirm>
            </div>
        @endif
    {!! Form::close() !!}


    <h3 class="mb-2">
        {{ __('settings.billing.title') }}
    </h3>
    {!! Form::model(auth()->user(), ['method' => 'PATCH', 'route' => ['settings.billing-info']]) !!}
        <p class="help-block">
            {{ __('settings.billing.placeholder') }}
        </p>
        {!! Form::textarea('profile[billing]', null, ['class' => 'rounded border p-2 w-full mb-2', 'rows' => 5, 'maxlength' => 1024]) !!}

        <div class="text-right">
            <x-buttons.confirm type="primary"  outline="true">
                <x-icon class="save"></x-icon>
                <span>{{ __('settings.billing.save') }}</span>
            </x-buttons.confirm>
        </div>
    {!! Form::close() !!}
@endsection


@section('scripts')
    @parent
    @vite('resources/js/billing.js')
@endsection
