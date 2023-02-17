<?php
/** @var \App\Models\Campaign $campaign */
?>
@section('content-header')
<div class="campaign-header @if(!empty($campaign->header_image))campaign-imaged-header" style="background-image: url({{ Img::crop(1200, 400)->url($campaign->header_image) }}) @else no-header @endif ">


    <div class="campaign-header-content">
        <div class="campaign-content">
            <div class="campaign-head">
                <a href="{{ route('overview', $campaign) }}" title="{!! $campaign->name !!}" class="campaign-title">
                    {!! $campaign->name !!}
                </a>
                    <div class="action-bar">
                        @can ('follow', $campaign)
                            <button id="campaign-follow" class="btn btn-default btn-xl" data-id="{{ $campaign->id }}"
                                    style="display: none"
                                    data-following="{{ $campaign->isFollowing() ? true : false }}"
                                    data-follow="{{ __('dashboard.actions.follow') }}"
                                    data-unfollow="{{ __('dashboard.actions.unfollow') }}"
                                    data-url="{{ route('follow', $campaign) }}"
                                    data-toggle="tooltip" title="{{ __('dashboard.helpers.follow') }}"
                                    data-placement="bottom"
                            >
                                <i class="fa-solid fa-star"></i> <span id="campaign-follow-text"></span>
                            </button>
                        @endcan
                        @can('apply', $campaign)
                            <button id="campaign-apply" class="btn btn-default btn-xl mr-2" data-id="{{ $campaign->id }}"
                                    data-url="{{ route('application', $campaign) }}"
                                    data-toggle="ajax-modal" title="{{ __('dashboard.helpers.join') }}"
                                    data-target="#large-modal"
                                    data-placement="bottom"
                            >
                                <i class="fa-solid fa-door-open"></i> {{ __('dashboard.actions.join') }}
                            </button>
                        @endcan

                        @cannot('update', $campaign)
                            @if(!empty($dashboards))
                                <div class="btn-group pull-right">
                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-th-large"></i>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        @if (!empty($dashboard))
                                            <li>
                                                <a href="{{ route('dashboard', [$campaign->id, 'dashboard' => 'default']) }}">
                                                    {{ __('dashboard.dashboards.default.title')}}
                                                </a>
                                            </li>
                                        @endif
                                        @foreach ($dashboards as $dash)
                                            @if (!empty($dashboard) && $dash->id == $dashboard->id)
                                                @continue
                                            @endif
                                            <li>
                                                <a href="{{ route('dashboard', [$campaign->id, 'dashboard' => $dash->id]) }}">
                                                    {!! $dash->name !!}
                                                </a>
                                            </li>
                                        @endforeach

                                        @can('dashboard', $campaign)
                                            <li class="divider"></li>
                                            <li>
                                                <a href="{{ route('dashboard.setup', !empty($dashboard) ? ['campaign' => $campaign, 'dashboard' => $dashboard->id] : ['campaign' => $campaign]) }}">
                                                    {{ __('dashboard.settings.title') }}
                                                </a>
                                            </li>
                                        @endcan
                                    </ul>
                                </div>
                            @else
                                @can('dashboard', $campaign)
                                <a href="{{ route('dashboard.setup', ['campaign' => $campaign]) }}" class="btn btn-default btn-xl" title="{{ __('dashboard.settings.title') }}">
                                    <i class="fa-solid fa-th-large"></i>
                                </a>
                                @endcan
                            @endif
                        @endcannot

                        @can('update', $campaign)
                        <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-default dropdown-toggle" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis-h"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right">
                                @if (!empty($dashboard))
                                    <li>
                                        <a href="{{ route('dashboard', [$campaign->id, 'dashboard' => 'default']) }}">
                                            <i class="fa-solid fa-th-large"></i> {{ __('dashboard.dashboards.default.title')}}
                                        </a>
                                    </li>
                                @endif
                                @foreach ($dashboards as $dash)
                                    @if (!empty($dashboard) && $dash->id == $dashboard->id)
                                        @continue
                                    @endif
                                    <li>
                                        <a href="{{ route('dashboard', [$campaign->id, 'dashboard' => $dash->id]) }}">
                                            <i class="fa-solid fa-th-large"></i> {!! $dash->name !!}
                                        </a>
                                    </li>
                                @endforeach
                                <li>
                                    <a href="{{ route('dashboard.setup', !empty($dashboard) ? ['campaign' => $campaign, 'dashboard' => $dashboard->id] : ['campaign' => $campaign]) }}" title="{{ __('dashboard.settings.title') }}">
                                        <i class="fa-solid fa-cog"></i> {{ __('dashboard.settings.title') }}
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="{{ route('edit', $campaign) }}">
                                        <i class="fa-solid fa-pencil"></i> {{ __('campaigns.show.actions.edit') }}
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li>
                                    <a href="{{ route('campaign_users.index', $campaign) }}"  title="{{ __('campaigns.show.tabs.members') }}">
                                        <i class="fa-solid fa-user"></i> {{ __('campaigns.show.tabs.members') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('campaign_roles.index', $campaign) }}" title="{{  __('campaigns.show.tabs.roles') }}">
                                        <i class="fa-solid fa-user-tag"></i> {{ __('campaigns.show.tabs.roles') }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('modules', $campaign) }}" title="{{ __('campaigns.show.tabs.settings') }}">
                                        <i class="fa-solid fa-th-large"></i> {{ __('campaigns.show.tabs.settings') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        @endcan
                    </div>
            </div>
            @if ($campaign->hasPreview())
                <div class="preview">
                    {!! $campaign->preview() !!}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
