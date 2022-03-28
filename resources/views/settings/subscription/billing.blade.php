<?php /**
 * @var \App\Models\CampaignBoost $boost
 * @var \App\Models\Campaign $campaign
 */
?>
@extends('layouts.app', [
    'title' => __('settings.subscription.billing.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
])

@section('content')
    @include('partials.errors')
    <div class="box box-solid">
        <div class="box-header with-border">
            <h3 class="box-title">
                {{ __('settings.subscription.billing.title') }}
            </h3>
        </div>
        <div class="box-body">
            <p>
                {!! __('settings.subscription.billing.helper', [
                    'stripe' => link_to('https://www.stripe.com', 'Stripe', ['target' => '_blank'])
                ]) !!}
            </p>

            <div class="row">
                <div class="col-lg-6">
                    <strong>
                        {{ __('settings.subscription.billing.saved' )}}
                    </strong>
                    <div id="billing">
                        <billing-management
                                api_token="{{ $stripeApiToken }}"
                                trans="{{ $translations }}"
                        ></billing-management>
                    </div>


                    {!! Form::model(auth()->user(), ['method' => 'PATCH', 'route' => ['settings.billing.save']]) !!}
                    <div class="form-group">
                        <label>{{ __('settings.subscription.fields.currency') }}</label>
                        {!! Form::select('currency', ['' => __('settings.subscription.currencies.usd'), 'eur' => __('settings.subscription.currencies.eur')], null, ['class' => 'form-control']) !!}
                    </div>
                    <button class="btn btn-primary margin-bottom">
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
