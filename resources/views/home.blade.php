<?php /**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignDashboardWidget $widget
 */ ?>
@php
    $position = 0;
    $seoTitle = (!empty($dashboard) ? $dashboard->name : __('sidebar.dashboard')) .  ' - ' . $campaign->name;
    $row = 0;
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
            elseif (!$widget->visible()):
                continue;
            endif; ?>
            @if ($position + $widget->colSize() > 12)
                </div>
                @includeWhen($row % 3 === 0 || $row === 0, 'partials.ads.inline')
                <div class="row">
                @php $position = 0; $row++; @endphp
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
            <a href="{{ route('dashboard.setup', !empty($dashboard) ? ['dashboard' => $dashboard->id] : []) }}" class="btn2 btn-lg btn-primary" title="{{ __('dashboard.settings.title') }}">
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
