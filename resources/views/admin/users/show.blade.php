<?php
/** @var \App\User $model */
?>

<div class="row">
    <div class="col-md-6">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h4 class="box-title">{{ $model->name }} #{{ $model->id }}</h4>
            </div>
            <div class="box-body">
                <dl class="dl-horizontal">
                    <dt>Email</dt>
                    <dd>{{ $model->email }} @if ($model->provider) ({{ $model->provider }})@endif</dd>

                    <dt>Created at</dt>
                    <dd>{{ $model->created_at }}</dd>

                    <dt>Last Login</dt>
                    <dd>{{ $model->last_login_at }}</dd>

                    @if($model->referrer)
                        <dt>Referral</dt>
                        <dd>{{ $model->referrer->code }}</dd>
                    @endif

                    @if ($discord = $model->apps->where('app', 'discord')->first())
                        <dt>
                            <i class="fab fa-discord"></i>
                        </dt>
                        <dd>{{ $discord->settings['username'] }}#{{ $discord->settings['discriminator'] }}</dd>
                    @endif
                </dl>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-solid">
            <div class="box-header with-border">
                <h4 class="box-title">Subscription</h4>
            </div>
            <div class="box-body">
                <dl class="dl-horizontal">
                @if ($model->hasPatreonSync())
                    <dt>{{ __('settings.subscription.fields.plan') }}</dt>
                    <dd>{{ $model->patreon_pledge }}</dd>
                    <dt>{{ __('settings.subscription.fields.billing') }}</dt>
                    <dd>By Patreon</dd>
                @else
                    <dt>{{ __('settings.subscription.fields.plan') }}</dt>
                    <dd>{{ $service->currentPlan() }}</dd>
                    <dt>{{ __('settings.subscription.fields.billing') }}</dt>
                    <dd>
                    @if ($model->subscribedToPlan($service->yearlyPlans(\App\Models\Patreon::PLEDGE_OWLBEAR), 'kanka'))
                        {{ __('settings.subscription.plans.cost_yearly', ['amount' => 55.00, 'currency' => $currency]) }}
                    @elseif ($model->subscribedToPlan($service->monthlyPlans(\App\Models\Patreon::PLEDGE_OWLBEAR), 'kanka'))
                        {{ __('settings.subscription.plans.cost_monthly', ['amount' => 5.00, 'currency' => $currency]) }}
                    @elseif ($model->subscribedToPlan($service->yearlyPlans(\App\Models\Patreon::PLEDGE_ELEMENTAL), 'kanka'))
                        {{ __('settings.subscription.plans.cost_yearly', ['amount' => 275.00, 'currency' => $currency]) }}
                    @elseif ($model->subscribedToPlan($service->monthlyPlans(\App\Models\Patreon::PLEDGE_ELEMENTAL), 'kanka'))
                        {{ __('settings.subscription.plans.cost_monthly', ['amount' => 25.00, 'currency' => $currency]) }}
                    @else
                        {{ __('front.pricing.tier.free') }}
                    @endif
                        <dt>{{ __('settings.subscription.fields.currency') }}</dt>
                        <dd>
                            <span class="margin-r-5">{{ strtoupper($model->currency ?? 'USD') }}</span>
                        </dd>
                        @if ($model->subscribed('kanka'))
                            <dt>{{ __('settings.subscription.fields.active_since') }}</dt>
                            <dd>{{ $model->subscription('kanka')->created_at->isoFormat('MMMM D, Y') }}</dd>
                            @if ($service->user($model)->status() == \App\Services\SubscriptionService::STATUS_GRACE)
                                <dt>{{ __('settings.subscription.fields.active_until') }}</dt>
                                <dd>{{ $model->subscription('kanka')->ends_at->isoFormat('MMMM D, Y') }}</dd>
                            @endif
                        @endif
                    </dd>
                @endif
                    <dt>Boost override</dt>
                    <dd>@if ($model->booster_count)
                        {{ $model->booster_count }}
                        @endif
                        <a href="#" class="" data-toggle="modal" data-target="#user-booster"><i class="fa fa-edit"></i></a>
                    </dd>
                </dl>
            </div>
        </div>
    </div>
</div>


<div class="box box-solid">
    <div class="box-header with-border">
        <h4 class="box-title">Campaigns</h4>
    </div>
    <div class="box-body">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>Campaign</th>
                <th>User Roles</th>
                <th>
                    <span class="hidden-xs">Members</span>
                    <i class="fa fa-users visible-xs"></i>
                </th>
                <th>
                    <span class="hidden-xs">Boosted</span>
                    <i class="fa fa-rocket visible-xs"></i>
                </th>
            </tr>
            </thead>
            <tbody>

@foreach ($model->campaigns as $campaign)
            <tr>
                <td>
                    {!! $campaign->dashboard() !!}
                    @if ($campaign->is_public)
                        <i class="fa fa-eye" title="Campaign is public"></i>
                    @else
                        <i class="fa fa-lock" title="Campaign is private"></i>
                    @endif
                </td>
                <td>
                    @foreach ($model->campaignRoles->where('campaign_id', $campaign->id) as $role)
                        <span class="label label-default">{{ $role->name }}</span>
                    @endforeach
                </td>
                <td>
                    {{ $campaign->members->count() }}
                </td>
                <td>
                    @if ($campaign->boost_count > 1)
                        <span class="label label-info hidden-xs">
                            Superboosted
                        </span>

                        <span class="label label-info visible-xs">
                            SB
                        </span>
                    @elseif ($campaign->boost_count == 1)
                        <span class="label label-info hidden-xs">Boosted</span>
                        <i class="fa fa-rocker visible-xs"></i>
                    @endif
                </td>
            </tr>
@endforeach
            </tbody>
        </table>
    </div>
</div>


<div class="row">
    <div class="col-md-6">

        <div class="box box-solid">
            <div class="box-header with-border">
                <h4 class="box-title">Kanka Roles</h4>
                <div class="box-tools">
                    <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#user-role">
                        <i class="fa fa-plus"></i> Add
                    </a>
                </div>
            </div>
            <div class="box-body">
                <dl class="dl-horizontal">
                @foreach ($model->roles as $role)
                    <dt>{{ $role->name }}</dt>
                    <dd>
                        <button class="btn btn-xs btn-danger delete-confirm" data-toggle="modal" data-name="{{ $role->name }}"
                                data-target="#delete-confirm" data-delete-target="remove-role-{{ $role->id }}"
                                title="{{ __('crud.remove') }}">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                    </dd>


                    {!! Form::open([
                        'method' => 'DELETE',
                        'route' => [
                            'admin.users.roles.destroy',
                            'user' => $model->id,
                        ],
                        'style' => 'display:inline',
                            'id' => 'remove-role-' . $role->id
                    ]) !!}
                    {!! Form::hidden('role_id', $role->id) !!}
                    {!! Form::close() !!}
                @endforeach
                </dl>

            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="user-booster" role="dialog" aria-labelledby="deleteConfirmLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4>
                        Custom user boost count
                    </h4>
                </div>
                <div class="panel-body">
                    {!! Form::model($model, ['route' => ['admin.users.booster_count', $model]]) !!}
                    <div class="form-group">
                        <label>Boost count</label>
                        {!! Form::number('booster_count', null, ['class' => 'form-control']) !!}
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="user-role" role="dialog" aria-labelledby="deleteConfirmLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4>
                        Add role for user
                    </h4>
                </div>
                <div class="panel-body">
                    {!! Form::model($model, ['route' => ['admin.users.roles', $model]]) !!}
                    <div class="form-group">
                        <label>Role</label>
                        {!! Form::select('role_id', \TCG\Voyager\Models\Role::pluck('name', 'id')->toArray(), null, ['class' => 'form-control']) !!}
                    </div>
                    <button type="submit" class="btn btn-primary">Add</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
