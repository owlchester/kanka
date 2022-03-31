<?php /** @var App\Models\Campaign $campaign */


$buttons = [];
if (auth()->check()) {

    if (!$campaign->boosted()) {
        $buttons[] = '<a href="' . route('settings.boost', ['campaign' => $campaign->id]) .'" class="btn btn-block bg-maroon btn-boost">
            <i class="fa fa-rocket"></i> ' . __('campaigns.show.actions.boost') . '</a>';
    }
    if (auth()->user()->can('update', $campaign)) {
        $buttons[] = '<a href="'. route('campaigns.edit', $campaign->id) .'" class="btn btn-primary btn-block">
            <i class="fa fa-edit" aria-hidden="true"></i> '. __('campaigns.show.actions.edit') .'</a>';
    }
    if (auth()->user()->can('leave', $campaign)) {
        $buttons[] = '<button data-url="'. route('campaigns.leave') . '" class="btn btn-warning btn-block click-confirm" data-toggle="modal" data-target="#click-confirm" data-message="' . __('campaigns.leave.confirm', ['name' => $campaign->name]) . '">
                <i class="fa fa-sign-out-alt" aria-hidden="true"></i> ' . __('campaigns.show.actions.leave') . '
            </button>';
    }

    if (auth()->user()->can('roles', $campaign)) {
        if (auth()->user()->can('delete', $campaign)) {
            $buttons[] = '<button class="btn btn-block btn-danger delete-confirm" data-name="' . $campaign->name . '" data-toggle="modal" data-target="#delete-confirm" data-delete-target="delete-campaign-confirm-form">
        <i class="fa fa-trash" aria-hidden="true"></i> ' . __('campaigns.destroy.action') . '
    </button>' . Form::open(['method' => 'DELETE', 'route' => ['campaigns.destroy', $campaign->id], 'style' => 'display:inline', 'id' => 'delete-campaign-confirm-form']) . Form::close();
        } else {
            $buttons[] = '<span class="btn btn-block btn-danger disabled" title="' . __('campaigns.destroy.helper') . '" data-toggle="tooltip">
                    <i class="fa fa-trash" aria-hidden="true"></i> ' . __('campaigns.destroy.action') . '</span>
    <p class="visible-xs visible-sm help-block text-center">' . __('campaigns.destroy.helper') . '</p>';
        }
    }
}
?>
@if (auth()->check() && !empty($buttons))
<div class="box box-solid">
    <div class="box-body box-profile">
        {!! implode("\n", $buttons) !!}
    </div>
</div>
@endif

    <div class="hidden-xs hidden-sm">
        <div class="box box-solid entity-submenu">
            <div class="box-body no-padding">
                <ul class="nav nav-pills nav-stacked">
                    <li class="@if(empty($active) || $active == 'campaign')active @endif">
                        <a href="{{ route('campaign') }}">
                            {{ __('campaigns.show.tabs.campaign') }}
                        </a>
                    </li>
                    @can('update', $campaign)
                        <li class="@if(!empty($active) && $active == 'export')active @endif">
                            <a href="{{ route('campaign_export') }}">
                                {{ __('campaigns.show.tabs.export') }}
                            </a>
                        </li>
                    @endif
                    @can('update', $campaign)
                    <li class="@if(!empty($active) && $active == 'recovery')active @endif">
                        <a href="{{ route('recovery') }}">
                            {{ __('campaigns.show.tabs.recovery') }}
                            <span class="label label-default bg-maroon pull-right" title="{{ __('crud.tooltips.boosted_feature') }}" data-toggle="tooltip">
                                <i class="fas fa-rocket"></i>
                            </span>
                        </a>
                    </li>
                    @endcan
                    @can('stats', $campaign)
                        <li class="@if(!empty($active) && $active == 'stats')active @endif">
                            <a href="{{ route('stats') }}">
                                {{ __('campaigns.show.tabs.achievements') }}
                                <span class="label label-default bg-maroon pull-right" title="{{ __('crud.tooltips.boosted_feature') }}" data-toggle="tooltip">
                            <i class="fas fa-rocket"></i>
                        </span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
        </div>

        @if (auth()->check() && (auth()->user()->can('members', $campaign) || auth()->user()->can('submissions', $campaign) || auth()->user()->can('roles', $campaign)))
        <div class="box box-solid entity-submenu">
            <div class="box-body no-padding">
                <ul class="nav nav-pills nav-stacked">
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
                </ul>
            </div>
        </div>
        @endif

        <div class="box box-solid entity-submenu">
            <div class="box-body no-padding">
                <ul class="nav nav-pills nav-stacked">
                    @can('update', $campaign)
                    <li class="@if(!empty($active) && $active == 'settings')active @endif">
                        <a href="{{ route('campaign_settings') }}">
                            {{ __('campaigns.show.tabs.settings') }}
                        </a>
                    </li>
                    @endcan
                    @if(config('marketplace.enabled'))
                        <li class="@if (!empty($active) && $active == 'plugins')active @endif">
                            <a href="{{ route('campaign_plugins.index') }}">
                                {{ __('campaigns.show.tabs.plugins') }}
                                <span class="label label-default bg-maroon pull-right" title="{{ __('crud.tooltips.boosted_feature') }}" data-toggle="tooltip">
                                <i class="fas fa-rocket"></i>
                            </span>
                            </a>
                        </li>
                    @endif
                    @can('update', $campaign)
                    <li class="@if(!empty($active) && $active == 'default-images')active @endif">
                        <a href="{{ route('campaign.default-images') }}">
                            {{ __('campaigns.show.tabs.default-images') }}
                            <span class="label label-default bg-maroon pull-right" title="{{ __('crud.tooltips.boosted_feature') }}" data-toggle="tooltip">
                                <i class="fas fa-rocket"></i>
                            </span>
                        </a>
                    </li>
                    <li class="@if(!empty($active) && $active == 'styles')active @endif">
                        <a href="{{ route('campaign_styles.index') }}">
                            {{ __('campaigns.show.tabs.styles') }}
                            <span class="label label-default bg-maroon pull-right" title="{{ __('crud.tooltips.boosted_feature') }}" data-toggle="tooltip">
                                <i class="fas fa-rocket"></i>
                            </span>
                        </a>
                    </li>
                    <li class="@if(!empty($active) && $active == 'sidebar')active @endif">
                        <a href="{{ route('campaign-sidebar') }}">
                            {{ __('campaigns.show.tabs.sidebar') }}
                            <span class="label label-default bg-maroon pull-right" title="{{ __('crud.tooltips.boosted_feature') }}" data-toggle="tooltip">
                                <i class="fas fa-rocket"></i>
                            </span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </div>
        </div>
    </div>

    @php
    $menuOptions = [];
    $menuOptions['campaign'] = [
        'label' => __('campaigns.show.tabs.campaign'),
        'route' => route('campaign')
    ];
    if (auth()->check()) {
        if (auth()->user()->can('update', $campaign)) {
            $menuOptions['export'] = [
                    'label' => __('campaigns.show.tabs.export'),
                    'route' => route('campaign_export')
            ];
            $menuOptions['recovery'] = [
                    'label' => __('campaigns.show.tabs.recovery'),
                    'route' => route('recovery')
            ];
        }
        if (auth()->user()->can('stats', $campaign)) {
            $menuOptions['stats'] = [
                    'label' => __('campaigns.show.tabs.achievements'),
                    'route' => route('stats')
            ];
        }
        if (auth()->user()->can('members', $campaign)) {
            $menuOptions['users'] = [
                    'label' => __('campaigns.show.tabs.members'),
                    'route' => route('campaign_users.index')
            ];
        }
        if (auth()->user()->can('submissions', $campaign)) {
            $menuOptions['submissions'] = [
                    'label' => __('campaigns.show.tabs.applications'),
                    'route' => route('campaign_submissions.index')
            ];
        }
        if (auth()->user()->can('roles', $campaign)) {
            $menuOptions['roles'] = [
                    'label' => __('campaigns.show.tabs.roles'),
                    'route' => route('campaign_roles.index')
            ];
        }

        if (auth()->user()->can('update', $campaign)) {
            $menuOptions['settings'] = [
                'label' => __('campaigns.show.tabs.settings'),
                'route' => route('campaign_settings')
            ];
            $menuOptions['default-images'] = [
                'label' => __('campaigns.show.tabs.default-images'),
                'route' => route('campaign.default-images')
            ];
            $menuOptions['styles'] = [
                'label' => __('campaigns.show.tabs.styles'),
                'route' => route('campaign_styles.index')
            ];
            $menuOptions['sidebar'] = [
                'label' => __('campaigns.show.tabs.sidebar'),
                'route' => route('campaign-sidebar')
            ];
        }
    }

    if (config('marketplace.enabled')) {
        $menuOptions['plugins'] = [
            'label' => __('campaigns.show.tabs.plugins'),
            'route' => route('campaign_plugins.index')
        ];
    }
    @endphp
    <div class="hidden-md hidden-lg" id="sm-a">
        <div class="box box-solid">
            <div class="box-body">
                <div class="form-group">
                    <select name="menu-switcher" class="form-control submenu-switcher">
                        @foreach ($menuOptions as $key => $option)
                            <option name="{{ $key }}" data-route="{{ $option['route'] . '#sm-a' }}" @if($key == $active) selected="selected" @endif>
                                {{ $option['label'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
