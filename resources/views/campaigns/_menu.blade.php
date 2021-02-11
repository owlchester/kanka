<?php /** @var App\Models\Campaign $campaign */ ?>
<div class="box box-solid">
    <div class="box-body box-profile">
        @if (!$campaign->boosted())
            <a href="{{ route('settings.boost', ['campaign' => $campaign->id]) }}" class="btn btn-block bg-maroon btn-boost">
                <i class="fa fa-rocket"></i> {{ __('campaigns.show.actions.boost') }}
            </a>
        @endif
        @can('update', $campaign)
            <a href="{{ route('campaigns.edit', $campaign->id) }}" class="btn btn-primary btn-block">
                <i class="fa fa-edit" aria-hidden="true"></i> {{ trans('campaigns.show.actions.edit') }}
            </a>
        @endcan

        @can('leave', $campaign)
            <button data-url="{{ route('campaigns.leave', $campaign->id) }}" class="btn btn-warning btn-block click-confirm" data-toggle="modal" data-target="#click-confirm" data-message="{{ trans('campaigns.leave.confirm', ['name' => $campaign->name]) }}">
                <i class="fa fa-sign-out-alt" aria-hidden="true"></i> {{ trans('campaigns.show.actions.leave') }}
            </button>
        @endcan


        @can('roles', $campaign)
            @can('delete', $campaign)
            <button class="btn btn-block btn-danger delete-confirm" data-name="{{ $campaign->name }}" data-toggle="modal" data-target="#delete-confirm" data-delete-target="delete-campaign-confirm-form">
                <i class="fa fa-trash" aria-hidden="true"></i> {{ __('campaigns.destroy.action') }}
            </button>
            {!! Form::open(['method' => 'DELETE', 'route' => ['campaigns.destroy', $campaign->id], 'style' => 'display:inline', 'id' => 'delete-campaign-confirm-form']) !!}
            {!! Form::close() !!}
            @else
                <span class="btn btn-block btn-danger disabled" title="{{ __('campaigns.destroy.helper') }}" data-toggle="tooltip">
                    <i class="fa fa-trash" aria-hidden="true"></i> {{ __('campaigns.destroy.action') }}
                </span>
                <p class="visible-xs visible-sm help-block text-center">{{ __('campaigns.destroy.helper') }}</p>
            @endif
        @endcan
    </div>
</div>

@if (!auth()->guest() and $campaign->userIsMember())
    <div class="box box-solid entity-submenu">
        <div class="box-header with-border">
            <h4 class="box-title">
                <span class="hidden-xs">{{ __('campaigns.show.menus.overview') }}</span>
                <span class="visible-xs">{{ __('crud.tabs.menu') }}</span>
            </h4>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" ><i class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="box-body no-padding">
            <ul class="nav nav-pills nav-stacked">
                <li class="@if(empty($active))active @endif">
                    <a href="{{ route('campaign') }}">
                        {{ __('campaigns.show.tabs.campaign') }}
                    </a>
                </li>
                @can('update', $campaign)
                <li class="@if(!empty($active) && $active == 'recovery')active @endif">
                    <a href="{{ route('recovery') }}">
                        {{ __('campaigns.show.tabs.recovery') }}
                    </a>
                </li>
                @endcan
                @can('roles', $campaign)
                    <li class="@if(!empty($active) && $active == 'export')active @endif">
                        <a href="{{ route('campaign_export') }}">
                            {{ __('campaigns.show.tabs.export') }}
                        </a>
                    </li>
                @endif
                @can('stats', $campaign)
                    @if($campaign->boosted(true))
                        <li class="@if(!empty($active) && $active == 'stats')active @endif">
                            <a href="{{ route('stats') }}">
                                {{ __('campaigns.show.tabs.achievements') }}
                            </a>
                        </li>
                    @endif
                @endcan

                <li class="nav-section">
                    {{ __('campaigns.show.menus.user_management') }}
                </li>

                @can('members', $campaign)
                <li class="@if(!empty($active) && $active == 'users')active @endif">
                    <a href="{{ route('campaign_users.index') }}">
                        {{ __('campaigns.show.tabs.members') }}
                    </a>
                </li>
                @endcan
                @can('submissions', $campaign)
                <li class="@if(!empty($active) && $active == 'submissions')active @endif">
                    <a href="{{ route('campaign_submissions.index') }}">
                        {{ __('campaigns.show.tabs.applications') }}
                        @if ($campaign->submissions()->count() > 0) <span class="label label-default pull-right">
                            {{ $campaign->submissions()->count() }}
                        </span>@endif
                    </a>
                </li>
                @endcan
                @can('roles', $campaign)
                <li class="@if(!empty($active) && $active == 'roles')active @endif">
                    <a href="{{ route('campaign_roles.index') }}">
                        {{ __('campaigns.show.tabs.roles') }}
                    </a>
                </li>
                @endcan


                @can('update', $campaign)
                <li class="nav-section">
                    {{ __('campaigns.show.menus.configuration') }}
                </li>
                <li class="@if(!empty($active) && $active == 'settings')active @endif">
                    <a href="{{ route('campaign_settings') }}">
                        {{ __('campaigns.show.tabs.settings') }}
                    </a>
                </li>
                @if(config('marketplace.enabled'))
                    <li class="@if (!empty($active) && $active == 'plugins')active @endif">
                        <a href="{{ route('campaign_plugins.index') }}">
                            {{ __('campaigns.show.tabs.plugins') }}
                        </a>
                    </li>
                @endif
                <li class="@if(!empty($active) && $active == 'default-images')active @endif">
                    <a href="{{ route('campaign.default-images') }}">
                        {{ __('campaigns.show.tabs.default-images') }}
                    </a>
                </li>
                @endcan
            </ul>
        </div>
    </div>
@endif
