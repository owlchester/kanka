<?php /**
 * @var \App\Models\CampaignBoost $boost
 * @var \App\Models\Campaign $campaign
 * @var \App\User $user
 */
?>
@extends('layouts.app', [
    'title' => __('settings.subscription.manage_subscription'),
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
                        <button class="btn btn-danger delete-confirm" data-toggle="modal"
                                data-target="#cancel-confirm"
                                title="{{ __('crud.remove') }}">
                            <i class="fa fa-trash" aria-hidden="true"></i> {{ __('settings.subscription.actions.cancel_sub') }}
                        </button>
                    </div>
                    @endif
                </div>
            </div>

            @if ($user->subscribed('kanka'))
                <h4>{{ __('settings.subscription.fields.plan') }}</h4>
                @include('settings._' . $currentPlan['name'])
            @else
                <div id="subscription">
                    <subscription-management
                            api_token="{{ $stripeApiToken }}"
                            currency="{{ $currency }}"
                    ></subscription-management>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="cancel-confirm" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">

            {!! Form::open([
                'method' => 'DELETE',
                'route' => [
                    'settings.subscription.cancel'
                ],
            ]) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ trans('settings.subscription.actions.cancel_sub') }}</h4>
                </div>
                <div class="modal-body">
                    <p class="help-block">
                        {!! __('settings.subscription.cancel.text')!!}
                    </p>

                    <div class="form-group">
                        <label>{{ __('settings.subscription.fields.reason') }}</label>
                        {!! Form::textarea(
                            'reason',
                            null,
                            [
                                'placeholder' => __('settings.subscription.placeholders.reason'),
                                'class' => 'form-control',
                                'rows' => 4,
                            ]
                        ) !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('crud.cancel') }}</button>
                    <button type="submit" class="btn btn-danger"><span class="fa fa-trash"></span> {{ trans('crud.click_modal.confirm') }}</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    <div class="modal">
    </div>
@endsection



@if (!$user->subscribed('kanka'))
    @section('scripts')
        @parent
        <script src="{{ mix('js/subscription.js') }}" defer></script>
    @endsection
@endif

@section('styles')
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/subscription.css') }}" rel="stylesheet">
@endsection
