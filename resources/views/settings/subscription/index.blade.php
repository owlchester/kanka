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

            <div class="row">
                <div class="col-md-6">
                    <div class="box box-solid">
                        <div class="box-body">
                            <h3 class="page-header with-border">{{ __('settings.subscription.sub_status') }}</h3>
                            <dl class="dl-horizontal">
                            @if ($user->hasPatreonSync())
                                    <dt>{{ __('settings.subscription.fields.plan') }}</dt>
                                    <dd>{{ $user->patreon_pledge }}</dd>
                                    <dt>{{ __('settings.subscription.fields.billed_monthly') }}</dt>
                                    <dd>By Patreon</dd>
                            @else
                                <dt>{{ __('settings.subscription.fields.plan') }}</dt>
                                <dd>{{ $currentPlan['name'] }}</dd>
                                <dt>{{ __('settings.subscription.fields.billed_monthly') }}</dt>
                                <dd>@if ($currentPlan['name'] != 'Kobold'){{ $currency }}@endif{{ $currentPlan['price'] }}</dd>
                                <dt>{{ __('settings.subscription.fields.currency') }}</dt>
                                <dd>
                                    <span class="margin-r-5">{{ strtoupper($user->currency ?? 'USD') }}</span>
                                    <a href="#" data-toggle="modal"
                                       data-target="#change-currency">
                                        <i class="fa fa-pencil-alt"></i> {{ __('crud.edit') }}
                                    </a>
                                </dd>
                                    @if ($user->subscribed('kanka'))
                                        <dt>{{ __('settings.subscription.fields.active_since') }}</dt>
                                        <dd>{{ $user->subscription('kanka')->created_at->isoFormat('MMMM D, Y') }}</dd>
                                        @if ($status == \App\Services\SubscriptionService::STATUS_GRACE)
                                            <dt>{{ __('settings.subscription.fields.active_until') }}</dt>
                                            <dd>{{ $user->subscription('kanka')->ends_at->isoFormat('MMMM D, Y') }}</dd>
                                        @endif
                                    @endif

                            @endif
                                <dt>{{ __('settings.subscription.fields.payment_method') }}</dt>
                                <dd>
                                    @if ($user->hasPaymentMethod())
                                        @php $method = $user->defaultPaymentMethod(); @endphp
                                        {{ __('settings.subscription.payment_method.saved', ['brand' => ucfirst($method->card->brand), 'last4' => $method->card->last4]) }}
                                    @else
                                        {{ __('settings.subscription.payment_method.add_one' ) }}
                                        {{ link_to_route('settings.billing', __('settings.subscription.payment_method.new_card' )) }}
                                    @endif
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="box box-solid">
                        <div class="box-body">
                            <h3 class="page-header with-border">{{ __('settings.invoices.title') }}</h3>
                            @if (!empty($invoices))
                                <dl class="dl-horizontal">
                                @foreach ($invoices as $invoice)
                                    <dt>{{ $invoice->date()->toFormattedDateString() }}</dt>
                                    <dd>
                                        {{ $invoice->total() }}
                                    </dd>
                                @endforeach
                                </dl>
                                <div class="text-center">
                                    {{ link_to_route('settings.invoices', __('settings.invoices.actions.view_all')) }}
                                </div>
                            @else
                                <p class="text-muted">
                                    {{ __('settings.invoices.empty') }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="box box-solid">
                <div class="box-body">
                    <button class="btn btn-secondary btn-sm pull-right" data-toggle="modal"
                            data-target="#change-information">
                        <i class="fas fa-question-circle" aria-hidden="true"></i> {{ __('settings.subscription.upgrade_downgrade.button') }}
                    </button>
                    <h3 class="page-header with-border">{{ __('settings.subscription.tiers') }}</h3>
                    <table class="table table-bordered tiers">
                        <thead>
                        <tr>
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
                                        <span class="price">
                                            {{ __('tiers.pricing', ['amount' => 5, 'currency' => $user->currencySymbol()]) }}
                                        </span>
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
                                        <span class="price">
                                            {{ __('tiers.pricing', ['amount' => 25, 'currency' => $user->currencySymbol()]) }}
                                        </span>
                                    </div>
                                </div>
                            </th>
                        </tr>
                        @if ($user->hasPatreonSync())
                            <tr>
                                <th class="text-center" colspan="3">
                                    <div class="alert alert-warning">
                                        {!! __('settings.subscription.warnings.patreon', ['patreon' => link_to_route('settings.patreon', __('settings.menu.patreon'))]) !!}
                                    </div>
                                </th>
                            </tr>
                        @else
                        <tr>
                            @if ($status != \App\Services\SubscriptionService::STATUS_GRACE)
                            <th class="align-middle">
                                @if($currentPlan['name'] === 'Kobold')
                                    <a class="btn btn-block btn-sm btn-default disabled">
                                        {{ __('tiers.current') }}
                                    </a>
                                @else
                                    <a class="btn btn-block btn-sm btn-success" data-toggle="ajax-modal" data-target="#subscribe-confirm" data-url="{{ route('settings.subscription.change', ['tier' => \App\Models\Patreon::PLEDGE_KOBOLD]) }}">
                                        {{ __('settings.subscription.subscription.actions.rollback', ['tier' => 'Kobold']) }}
                                    </a>
                                @endif
                            </th>
                            <th class="align-middle">
                                @if($user->isOwlbear())
                                    <a class="btn btn-block btn-sm btn-default disabled">
                                        {{ __('tiers.current') }}
                                    </a>
                                @elseif ($user->isElementalPatreon())
                                    <a class="btn btn-block btn-sm btn-default disabled">
                                        {{ __('settings.subscription.subscription.actions.downgrading') }}
                                    </a>
                                @else
                                    <a class="btn btn-block btn-sm btn-success" data-toggle="ajax-modal" data-target="#subscribe-confirm" data-url="{{ route('settings.subscription.change', ['tier' => \App\Models\Patreon::PLEDGE_OWLBEAR]) }}">
                                        {{ __('settings.subscription.subscription.actions.subscribe', ['tier' => 'Owlbear']) }}
                                    </a>
                                @endif
                            </th>
                            <th class="align-middle">
                                @if($user->isElementalPatreon())
                                    <button class="btn btn-block btn-sm btn-default disabled">
                                        {{ __('tiers.current') }}
                                    </button>
                                @else
                                    <a class="btn btn-block btn-sm btn-success" data-toggle="ajax-modal" data-target="#subscribe-confirm" data-url="{{ route('settings.subscription.change', ['tier' => \App\Models\Patreon::PLEDGE_ELEMENTAL]) }}">
                                        {{ __('settings.subscription.subscription.actions.subscribe', ['tier' => 'Elemental']) }}
                                    </a>
                                @endif
                            </th>
                            @else
                                <td colspan="3" class="text-center">
                                    <p class="help-block">
                                        {{ __('settings.subscription.cancelled') }}
                                    </p>
                                </td>
                            @endif
                        </tr>
                        @endif
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{ __('tiers.features.file_size', ['size' => '2mb']) }}</td>
                            <td>{{ __('tiers.features.file_size', ['size' => '8mb']) }}</td>
                            <td>{{ __('tiers.features.file_size', ['size' => '25mb']) }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('tiers.features.map_size', ['size' => '2mb']) }}</td>
                            <td>{{ __('tiers.features.map_size', ['size' => '10mb']) }}</td>
                            <td>{{ __('tiers.features.map_size', ['size' => '25mb']) }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('tiers.features.pagination', ['amount' => 45]) }}</td>
                            <td>{{ __('tiers.features.pagination', ['amount' => 100]) }}</td>
                            <td>{{ __('tiers.features.pagination', ['amount' => 100]) }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><i class="fa fa-check"></i> 3 {!! link_to_route('front.features', __('tiers.features.boosters'), '#boosts', ['target' => '_blank']) !!}</td>
                            <td><i class="fa fa-check"></i> 10 {!! link_to_route('front.features', __('tiers.features.boosters'), '#boosts', ['target' => '_blank']) !!}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><i class="fa fa-check"></i> {{ __('tiers.features.discord') }}</td>
                            <td><i class="fa fa-check"></i> {{ __('tiers.features.discord') }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><i class="fa fa-check"></i> {!! link_to_route('front.about', __('tiers.features.hall_of_fame'), '#patreon', ['target' => '_blank']) !!}</td>
                            <td><i class="fa fa-check"></i> {!! link_to_route('front.about', __('tiers.features.hall_of_fame'), '#patreon', ['target' => '_blank']) !!}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><i class="fa fa-check"></i> {{ __('tiers.features.nice_image') }}</td>
                            <td><i class="fa fa-check"></i> {{ __('tiers.features.nice_image') }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><i class="fa fa-check"></i> {!! link_to_route('community-votes.index', __('tiers.features.community_vote'), ['target' => '_blank']) !!}</td>
                            <td><i class="fa fa-check"></i> {!! link_to_route('community-votes.index', __('tiers.features.community_vote'), ['target' => '_blank']) !!}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><i class="fa fa-check"></i> {{ __('tiers.features.vote_influence') }}</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <td><i class="fa fa-check"></i> {{ __('tiers.features.feature_influence') }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('tiers.features.api_requests', ['amount' => 30]) }}</td>
                            <td>{{ __('tiers.features.api_requests', ['amount' => 90]) }}</td>
                            <td>{{ __('tiers.features.api_requests', ['amount' => 90]) }}</td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="change-information" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ trans('settings.subscription.upgrade_downgrade.button') }}</h4>
                </div>
                <div class="modal-body">
                    <h4>{{ __('settings.subscription.upgrade_downgrade.upgrade.title') }}</h4>
                    <ul>
                        @foreach(__('settings.subscription.upgrade_downgrade.upgrade.bullets') as $key => $text)
                            <li>{{ $text }}</li>
                        @endforeach
                    </ul>

                    <hr />

                    <h4>{{ __('settings.subscription.upgrade_downgrade.downgrade.title') }}</h4>
                    <ul>
                        @foreach(__('settings.subscription.upgrade_downgrade.downgrade.bullets') as $key => $text)
                            <li>{{ $text }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="change-currency" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ trans('settings.subscription.currency.title') }}</h4>
                </div>
                <div class="modal-body">
                    {!! Form::model(auth()->user(), ['method' => 'PATCH', 'route' => ['settings.billing.save']]) !!}
                    <div class="form-group">
                        <label>{{ trans('settings.subscription.fields.currency') }}</label>
                        {!! Form::select('currency', ['' => trans('settings.subscription.currencies.usd'), 'eur' => trans('settings.subscription.currencies.eur')], null, ['class' => 'form-control']) !!}
                    </div>

                    <button class="btn btn-primary margin-bottom">
                        {{ trans('settings.subscription.actions.update_currency') }}
                    </button>
                    <input type="hidden" name="from" value="{{ 'settings.subscription' }}" />
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="subscribe-confirm" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content"></div>
        </div>
    </div>

    <input type="hidden" id="stripe-token" value="{{ config('services.stripe.key') }}" />
@endsection


@section('scripts')
    @parent
    <script src="{{ mix('js/subscription.js') }}" defer></script>
    <script src="https://js.stripe.com/v3/"></script>
@endsection

@section('styles')
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/subscription.css') }}" rel="stylesheet">
@endsection
