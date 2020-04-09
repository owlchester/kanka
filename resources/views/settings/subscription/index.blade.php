<?php /**
 * @var \App\Models\CampaignBoost $boost
 * @var \App\Models\Campaign $campaign
 * @var \App\User $user
 */
?>
@extends('layouts.app', [
    'title' => '',
    'breadcrumbs' => false
])

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-lg-2 col-sm-4">
            @include('settings.menu', ['active' => 'subscription'])
        </div>
        <div class="col-lg-10 col-sm-8">
            <div class="box box-solid">
                <div class="box-body">
                    <h3 class="page-header with-border">{{ __('settings.subscription.manage_subscription') }}</h3>
                    <p>
                        {!! __('settings.subscription.benefits', [
                            'features' => link_to_route('front.features', __('settings.patreon.benefits_features'), '#patreon', ['target' => '_blank']),
                            'strip' => link_to('https://www.stripe.com', 'Stripe', ['target' => '_blank'])
                        ]) !!}
                    </p>
                </div>
            </div>

            <div class="box box-solid">
                <div class="box-body">
                    <h3 class="page-header with-border">{{ __('settings.subscription.sub_status') }}</h3>
                    <dl class="dl-horizontal">
                        <dt>{{ __('settings.subscription.fields.plan') }}</dt>
                        <dd>{{ $currentPlan['name'] }}</dd>
                        <dt>{{ __('settings.subscription.fields.billed_monthly') }}</dt>
                        <dd>@if ($currentPlan['name'] != 'Kobold'){{ $currency }}@endif{{ $currentPlan['price'] }}</dd>


                        @if ($user->subscribed('kanka'))
                            <dt>{{ __('settings.subscription.fields.active_since') }}</dt>
                            <dd>{{ $user->subscription('kanka')->created_at->isoFormat('MMMM D, Y') }}</dd>
                            @if ($status == \App\Services\SubscriptionService::STATUS_GRACE)
                                <dt>{{ __('settings.subscription.fields.active_until') }}</dt>
                                <dd>{{ $user->subscription('kanka')->ends_at->isoFormat('MMMM D, Y') }}</dd>
                            @endif
                        @endif
                        <dt>{{ __('settings.subscription.fields.payment_method') }}</dt>
                        <dd>
                            @if ($user->hasPaymentMethod())
                                @php $method = $user->defaultPaymentMethod(); @endphp
                                {{ __('settings.subscription.payment_method.saved', ['brand' => ucfirst($method->card->brand), 'last4' => $method->card->last4]) }}
                            @else
                                {{ __('settings.subscription.payment_method.add_one' ) }}
                                {{ link_to_route('settings.billing', __('settings.subscription.payment_method.actions.add_new' )) }}
                            @endif
                        </dd>
                    </dl>

                    @if ($user->subscribed('kanka') && !$user->subscription('kanka')->cancelled())
                    <div class="text-right">
                        <button class="btn btn-danger delete-confirm" data-toggle="modal" data-name="{{ $currentPlan['name'] }}"
                                data-target="#delete-confirm" data-delete-target="cancel-subscription"
                                title="{{ __('crud.remove') }}">
                            <i class="fa fa-trash" aria-hidden="true"></i> {{ __('settings.subscription.actions.cancel_sub') }}
                        </button>
                    </div>
                    {!! Form::open([
                        'method' => 'DELETE',
                        'route' => [
                            'settings.subscription.cancel'
                        ],
                        'style' => 'display:inline',
                        'id' => 'cancel-subscription'
                    ]) !!}
                    {!! Form::close() !!}
                    @endif
                </div>
            </div>

            @if (!$user->subscribed('kanka'))
            <div id="subscription">
                <subscription-management
                        api_token="{{ $stripeApiToken }}"
                        currency="{{ $currency }}"
                ></subscription-management>
            </div>
            @else
                <h4>{{ __('settings.subscription.fields.plan') }}</h4>
                @include('settings._' . $currentPlan['name'])
            @endif
        </div>

    </div>
@endsection


@section('scripts')
    @parent
    <script src="{{ mix('js/subscription.js') }}" defer></script>
@endsection

@section('styles')
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/subscription.css') }}" rel="stylesheet">
@endsection
