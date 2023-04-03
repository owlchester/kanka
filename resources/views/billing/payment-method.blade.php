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
    <div class="max-w-3xl">
        <h1 class="mb-3">
            {{ __('billing/payment_methods.title') }}
        </h1>
        <p class="text-lg">
            {!! __('settings.subscription.billing.helper', [
                'stripe' => link_to('https://www.stripe.com', 'Stripe', ['target' => '_blank'])
            ]) !!}
        </p>
        <div class="rounded p-4 bg-box mb-5">
            <strong>
                {{ __('settings.subscription.billing.saved' )}}
            </strong>
            <div id="billing">
                <billing-management
                        api_token="{{ $stripeApiToken }}"
                        trans="{{ $translations }}"
                ></billing-management>
            </div>
        </div>


        <div class="rounded p-4 bg-box">

            {!! Form::model(auth()->user(), ['method' => 'PATCH', 'route' => ['billing.payment-method.save']]) !!}
            <div class="form-group">
                <label>{{ __('settings.subscription.fields.currency') }}</label>
                {!! Form::select('currency', ['' => __('settings.subscription.currencies.usd'), 'eur' => __('settings.subscription.currencies.eur')], auth()->user()->currency(), ['class' => 'form-control']) !!}
            </div>
            <button class="btn btn-primary mb-5">
                {{ __('settings.subscription.actions.update_currency') }}
            </button>
            {!! Form::close() !!}

        </div>
    </div>
@endsection


@section('scripts')
    @parent
    @vite('resources/js/billing.js')
@endsection
