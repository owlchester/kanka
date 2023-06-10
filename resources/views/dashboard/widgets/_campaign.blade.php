<?php
/** @var \App\Models\Campaign $campaign */
?>
@section('content-header')
<div class="campaign-header cover-background mb-3 p-2 relative z-[10] @if(!empty($campaign->header_image))campaign-imaged-header px-10 py-14" style="background-image: url({{ Img::crop(1200, 400)->url($campaign->header_image) }}) @else no-header @endif">

    <div class="campaign-header-content p-2  glass">
        <div class="campaign-content">
            <div class="campaign-head flex gap-2">
                <a href="{{ route('campaign') }}" title="{!! $campaign->name !!}" class="grow campaign-title text-2xl m-0 p-0">
                    {!! $campaign->name !!}
                </a>
                <div class="flex gap-2 action-bar">
                    @can ('follow', $campaign)
                        <button id="campaign-follow" class="btn2" data-id="{{ $campaign->id }}"
                                style="display: none"
                                data-following="{{ $campaign->isFollowing() ? true : false }}"
                                data-follow="{{ __('dashboard.actions.follow') }}"
                                data-unfollow="{{ __('dashboard.actions.unfollow') }}"
                                data-url="{{ route('campaign.follow') }}"
                                data-toggle="tooltip" title="{{ __('dashboard.helpers.follow') }}"
                                data-placement="bottom"
                        >
                            <i class="fa-solid fa-star"></i> <span id="campaign-follow-text"></span>
                        </button>
                    @endcan
                    @can('apply', $campaign)
                        <button id="campaign-apply" class="btn2" data-id="{{ $campaign->id }}"
                                data-url="{{ route('campaign.apply') }}"
                                data-toggle="ajax-modal" title="{{ __('dashboard.helpers.join') }}"
                                data-target="#large-modal"
                                data-placement="bottom"
                        >
                            <i class="fa-solid fa-door-open"></i> {{ __('dashboard.actions.join') }}
                        </button>
                    @endcan

                    @cannot('update', $campaign)
                        @if(!empty($dashboards))
                            <div class="dropdown ">
                                <button type="button" class="btn2 dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-th-large"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                    @if (!empty($dashboard))
                                        <li>
                                            <a href="{{ route('dashboard', ['dashboard' => 'default']) }}">
                                                {{ __('dashboard.dashboards.default.title')}}
                                            </a>
                                        </li>
                                    @endif
                                    @foreach ($dashboards as $dash)
                                        @if (!empty($dashboard) && $dash->id == $dashboard->id)
                                            @continue
                                        @endif
                                        <li>
                                            <a href="{{ route('dashboard', ['dashboard' => $dash->id]) }}">
                                                {!! $dash->name !!}
                                            </a>
                                        </li>
                                    @endforeach

                                    @can('dashboard', $campaign)
                                        <li class="divider"></li>
                                        <li>
                                            <a href="{{ route('dashboard.setup', !empty($dashboard) ? ['dashboard' => $dashboard->id] : []) }}">
                                                {{ __('dashboard.settings.title') }}
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        @else
                            @can('dashboard', $campaign)
                            <a href="{{ route('dashboard.setup') }}" class="btn2" title="{{ __('dashboard.settings.title') }}">
                                <i class="fa-solid fa-th-large"></i>
                            </a>
                            @endcan
                        @endif
                    @endcannot

                    @can('update', $campaign)
                    <div class="dropdown">
                        <button data-toggle="dropdown" class="btn2 dropdown-toggle" aria-expanded="false">
                            <i class="fa-solid fa-ellipsis-h"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            @if (!empty($dashboard))
                                <li>
                                    <a href="{{ route('dashboard', ['dashboard' => 'default']) }}">
                                        <i class="fa-solid fa-th-large"></i> {{ __('dashboard.dashboards.default.title')}}
                                    </a>
                                </li>
                            @endif
                            @foreach ($dashboards as $dash)
                                @if (!empty($dashboard) && $dash->id == $dashboard->id)
                                    @continue
                                @endif
                                <li>
                                    <a href="{{ route('dashboard', ['dashboard' => $dash->id]) }}">
                                        <i class="fa-solid fa-th-large"></i> {!! $dash->name !!}
                                    </a>
                                </li>
                            @endforeach
                            <li>
                                <a href="{{ route('dashboard.setup', !empty($dashboard) ? ['dashboard' => $dashboard->id] : []) }}" title="{{ __('dashboard.settings.title') }}">
                                    <x-icon class="cog"></x-icon> {{ __('dashboard.settings.title') }}
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="{{ route('campaigns.edit') }}">
                                    <x-icon class="pencil"></x-icon> {{ __('campaigns.show.actions.edit') }}
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="{{ route('campaign_users.index') }}"  title="{{ __('campaigns.show.tabs.members') }}">
                                    <x-icon class="fa-solid fa-user"></x-icon> {{ __('campaigns.show.tabs.members') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('campaign_roles.index') }}" title="{{  __('campaigns.show.tabs.roles') }}">
                                    <x-icon class="fa-solid fa-user-tag"></x-icon> {{ __('campaigns.show.tabs.roles') }}
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('campaign.modules') }}" title="{{ __('campaigns.show.tabs.settings') }}">
                                    <x-icon class="fa-solid fa-th-large"></x-icon> {{ __('campaigns.show.tabs.settings') }}
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
