<?php /**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\AppRelease $release
 */ ?>
@php
    $position = 0;
    $seoTitle = (!empty($dashboard) ? $dashboard->name : __('sidebar.dashboard')) .  ' - ' . $campaign->name;
@endphp

@extends('layouts.app', [
    'title' => __('dashboard.title') . ' ' . (!empty($dashboard) ? $dashboard->name : $campaign->name),
    'seoTitle' => $seoTitle,
    'breadcrumbs' => false,
    'canonical' => true,
    'contentId' => 'campaign-dashboard'
])

@section('og')
    <meta property="og:description" content="{{ !empty($campaign->excerpt) ? strip_tags($campaign->excerpt) : $campaign->tooltip() }}" />
    @if ($campaign->image)<meta property="og:image" content="{{ Img::crop(50, 50)->url($campaign->image)  }}" />@endif
    <meta property="og:url" content="{{ route('campaigns.show', $campaign)  }}" />
@endsection

@section('header-extra')
    <div class="dashboard-actions">
        @if(!empty($dashboards))
            <div class="btn-group pull-right">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <i class="fa fa-th-large"></i>
                </button>
                <ul class="dropdown-menu" role="menu">
                    @if (!empty($dashboard))
                        <li>
                            <a href="{{ route('dashboard', ['dashboard' => 'default']) }}">
                                <i class="fa fa-th-large"></i> {{ __('dashboard.dashboards.default.title')}}
                            </a>
                        </li>
                    @endif
                    @foreach ($dashboards as $dash)
                        @if (!empty($dashboard) && $dash->id == $dashboard->id)
                            @continue
                        @endif
                        <li>
                            <a href="{{ route('dashboard', ['dashboard' => $dash->id]) }}">
                                <i class="fa fa-th-large"></i> {!! $dash->name !!}
                            </a>
                        </li>
                    @endforeach

                    @if($settings)
                        <li>
                            <a href="{{ route('dashboard.setup', !empty($dashboard) ? ['dashboard' => $dashboard->id] : []) }}">
                                <i class="fa fa-cog"></i> {{ __('dashboard.settings.title') }}
                            </a>
                        </li>
                    @endif
                    @can('update', $campaign)
                        <li class="divider"></li>
                        <li>
                            <a href="{{ route('campaigns.edit', $campaign) }}">
                                <i class="fa fa-pencil"></i> {{ __('campaigns.show.actions.edit') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
        @elseif($settings)
            <a href="{{ route('dashboard.setup') }}" class="btn btn-default btn-xl" title="{{ __('dashboard.settings.title') }}">
                <i class="fa fa-th-large"></i>
            </a>
        @endif
        @can ('follow', $campaign)
            <button id="campaign-follow" class="btn btn-default btn-xl" data-id="{{ $campaign->id }}"
                    style="display: none"
                    data-following="{{ $campaign->isFollowing() ? true : false }}"
                    data-follow="{{ __('dashboard.actions.follow') }}"
                    data-unfollow="{{ __('dashboard.actions.unfollow') }}"
                    data-url="{{ route('campaign.follow') }}"
                    data-toggle="tooltip" title="{{ __('dashboard.helpers.follow') }}"
                    data-placement="bottom"
            >
                <i class="fa fa-star"></i> <span id="campaign-follow-text"></span>
            </button>
        @endcan
        @can('apply', $campaign)
            <button id="campaign-apply" class="btn btn-default btn-xl margin-r-5" data-id="{{ $campaign->id }}"
                    data-url="{{ route('campaign.apply') }}"
                    data-toggle="ajax-modal" title="{{ __('dashboard.helpers.join') }}"
                    data-target="#large-modal"
                    data-placement="bottom"
            >
                <i class="fas fa-door-open"></i> {{ __('dashboard.actions.join') }}
            </button>
        @endcan
    </div>
@endsection


@section('content')

    @includeWhen(!empty($releases), 'partials.releases')

    @if (empty($dashboard))
        @include('dashboard.widgets._campaign')
    @endif

    @include('partials.ads.top')

    <div class="dashboard-widgets">
        <div class="row">
        @foreach ($widgets as $widget)
            @if($widget->widget == \App\Models\CampaignDashboardWidget::WIDGET_CAMPAIGN)
                @include('dashboard.widgets._campaign')
                @continue;
            @endif
            <?php if (!in_array($widget->widget, \App\Models\CampaignDashboardWidget::WIDGET_VISIBLE) && (empty($widget->entity) || !EntityPermission::canView($widget->entity))):
                continue;
            elseif ($widget->widget == \App\Models\CampaignDashboardWidget::WIDGET_PREVIEW && !EntityPermission::canView($widget->entity)):
                continue;
            endif; ?>
            @if ($position + $widget->colSize() > 12)
                </div><div class="row">
            <?php $position = 0; ?>
            @endif
                <div class="col-md-{{ $widget->colSize() }}">
                    <div class="widget widget-{{ $widget->widget }}">
                        @include('dashboard.widgets._' . $widget->widget)
                    </div>
                </div>

            <?php $position += $widget->colSize(); ?>
        @endforeach
        </div>
    </div>

    @if ($settings)
        <div class="row margin-top">
            <div class="col-md-12 text-center">
                <a href="{{ route('dashboard.setup', !empty($dashboard) ? ['dashboard' => $dashboard->id] : []) }}" class="btn btn-default" title="{{ __('dashboard.settings.title') }}">
                    <i class="fa fa-cog"></i> {{ __('dashboard.settings.title') }}
                </a>
            </div>
        </div>

        @if($widgets->count() === 0)
            <div class="callout callout-info margin-top">
                {!! __('dashboard.setup.tutorial.text', [
    'blog' => link_to('https://blog.kanka.io/2020/09/20/how-to-style-your-kanka-campaign-dashboard/', __('dashboard.setup.tutorial.blog'), ['target' => '_blank'])
]) !!}
            </div>
        @endif
    @endif
@endsection

@section('scripts')
    <script src="{{ mix('js/dashboard.js') }}" defer></script>

    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
            integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
            crossorigin=""></script>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
          integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
          crossorigin=""/>
    <link href="{{ mix('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ mix('css/map-v3.css') }}" rel="stylesheet">
@endsection

@section('modals')
    @tutorial('welcome')
    <div class="modal fade tutorial-modal" id="tutorial-modal" role="dialog" aria-labelledby="tutorialModal" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="tutorialModalTitle">{{ __('tutorials/home.welcome.title', ['user' => auth()->user()->name]) }}</h4>
                </div>
                <div class="modal-body">
                    <p>{{ __('tutorials/home.welcome.first') }}</p>
                    <p>{{ __('tutorials/home.welcome.second') }}</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-warning pull-left" data-tutorial="disable" data-url="{{ route('settings.tutorial.disable') }}">
                        {{ __('tutorials/actions.disable') }}
                    </button>
                    <button class="btn btn-success" data-tutorial="next" data-url="{{ route('settings.tutorial.done', ['tutorial' => 'welcome', 'next' => 'dashboard_1']) }}">
                        {{ __('tutorials/actions.next') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endtutorial
@endsection
