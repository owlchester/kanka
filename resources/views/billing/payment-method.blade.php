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
    <div class="row">
        <div class="col-lg-6">
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">
                {{ __('billing/payment_methods.title') }}
            </h3>
        </div>
        <div class="box-body">
            <p>
                {!! __('settings.subscription.billing.helper', [
                    'stripe' => link_to('https://www.stripe.com', 'Stripe', ['target' => '_blank'])
                ]) !!}
            </p>

            <strong>
                {{ __('settings.subscription.billing.saved' )}}
            </strong>
            <div id="billing">
                <billing-management
                        api_token="{{ $stripeApiToken }}"
                        trans="{{ $translations }}"
                ></billing-management>
            </div>

            <hr />

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
        </div>
    </div>
@endsection


@section('scripts')
    @parent
    <script src="{{ mix('js/billing.js') }}" defer></script>
@endsection
