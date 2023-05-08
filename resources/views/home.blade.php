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
    <meta property="og:description" content="{{ $campaign->preview() }}" />
    @if ($campaign->image)<meta property="og:image" content="{{ Img::crop(50, 50)->url($campaign->image)  }}" />@endif
    <meta property="og:url" content="{{ route('campaigns.show', $campaign)  }}" />
@endsection

@section('header-extra')
    <div class="dashboard-actions">
        @if(!empty($dashboards))
            <div class="btn-group pull-right">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <x-icon class="fa-solid fa-th-large"></x-icon>
                </button>
                <ul class="dropdown-menu" role="menu">
                    @if (!empty($dashboard))
                        <li>
                            <a href="{{ route('dashboard', ['dashboard' => 'default']) }}">
                                <x-icon class="fa-solid fa-th-large"></x-icon>
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
                                <x-icon class="fa-solid fa-th-large"></x-icon>
                                {!! $dash->name !!}
                            </a>
                        </li>
                    @endforeach

                    @can('dashboard', $campaign)
                        <li>
                            <a href="{{ route('dashboard.setup', !empty($dashboard) ? ['dashboard' => $dashboard->id] : []) }}">
                                <x-icon class="cog"></x-icon>
                                {{ __('dashboard.settings.title') }}
                            </a>
                        </li>
                    @endcan
                    @can('update', $campaign)
                        <li class="divider"></li>
                        <li>
                            <a href="{{ route('campaigns.edit') }}">
                                <x-icon class="pencil"></x-icon>
                                {{ __('campaigns.show.actions.edit') }}
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
        @else
            @can('update', $campaign)
            <a href="{{ route('dashboard.setup') }}" class="btn btn-default btn-xl" title="{{ __('dashboard.settings.title') }}">
                <x-icon class="fa-solid fa-th-large"></x-icon>
                <span class="sr-only">{{ __('dashboard.settings.title') }}</span>
            </a>
            @endcan
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
                <x-icon class="fa-regular fa-star"></x-icon>
                <span id="campaign-follow-text"></span>
            </button>
        @endcan
        @can('apply', $campaign)
            <button id="campaign-apply" class="btn btn-default btn-xl mr-2" data-id="{{ $campaign->id }}"
                    data-url="{{ route('campaign.apply') }}"
                    data-toggle="ajax-modal" title="{{ __('dashboard.helpers.join') }}"
                    data-target="#large-modal"
                    data-placement="bottom"
            >
                <x-icon class="fa-solid fa-door-open"></x-icon>
                {{ __('dashboard.actions.join') }}
            </button>
        @endcan
    </div>
@endsection


@section('content')
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
            <?php if (!in_array($widget->widget, \App\Models\CampaignDashboardWidget::WIDGET_VISIBLE) && empty($widget->entity)):
                continue;
            elseif ($widget->widget == \App\Models\CampaignDashboardWidget::WIDGET_PREVIEW && !$widget->entity):
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

    @can('update', $campaign)
        <div class="text-center mt-6">
            <a href="{{ route('dashboard.setup', !empty($dashboard) ? ['dashboard' => $dashboard->id] : []) }}" class="btn btn-default btn-lg" title="{{ __('dashboard.settings.title') }}">
                <x-icon class="cog"></x-icon>
                {{ __('dashboard.settings.title') }}
            </a>
        </div>

        @if($widgets->count() === 0)
            <div class="mt-6"></div>
            <x-alert type="info">
                {!! __('dashboard.setup.tutorial.text', [
    'blog' => link_to('https://blog.kanka.io/2020/09/20/how-to-style-your-kanka-campaign-dashboard/', __('dashboard.setup.tutorial.blog'), ['target' => '_blank'])
]) !!}
            </x-alert>
        @endif
    @endcan
@endsection

@section('scripts')

    @vite('resources/js/dashboard.js')

    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js" integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg=" crossorigin=""></script>
    <script src="/js/vendor/leaflet/leaflet.markercluster.js"></script>
    <script src="/js/vendor/leaflet/leaflet.markercluster.layersupport.js"></script>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css" integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />

    @vite([
        'resources/sass/dashboard.scss',
        'resources/sass/map-v3.scss'
    ])
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
