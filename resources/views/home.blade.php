<?php /**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignDashboardWidget $widget
 */ ?>
@php
use App\Enums\Widget;
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
    <meta property="og:description" content="{{ $campaign->hasPreview() ? $campaign->preview() : __('seo.dashboard', ['campaign' => $campaign->name]) }}" />
    @if ($campaign->image)<meta property="og:image" content="{{ Img::crop(50, 50)->url($campaign->image)  }}" />@endif
    <meta property="og:url" content="{{ route('campaigns.show', $campaign)  }}" />
@endsection

@section('content')
    <div class="max-w-7xl mx-auto">
        @if (empty($dashboard))
            @include('dashboard.widgets._campaign')
        @endif

        @include('ads.top')

        <div class="dashboard-widgets grid grid-cols-12 gap-4 md:gap-5 ">

{{--            <x-alert type="error" class="col-span-12">--}}
{{--                <p>Dashboards are currently unavailable. We are working on bringing them back as soon as possible.</p>--}}
{{--            </x-alert>--}}
            @if (!$hasCampaignHeader)
                <div class="col-span-12 flex gap-5 justify-end">
                    @include('dashboard.widgets._actions')
                </div>
            @endif
            @foreach ($widgets as $widget)
                @if($widget->widget === Widget::Campaign)
                    @include('dashboard.widgets._campaign')
                    @continue;
                @endif
                <?php if (!in_array($widget->widget->value, [
                            Widget::Recent->value,
                            Widget::Random->value,
                            Widget::Header->value,
                            Widget::Welcome->value
                        ]) && empty($widget->entity)):
                    continue;
                elseif ($widget->widget === Widget::Preview && !$widget->entity):
                    continue;
                elseif (!$widget->visible()):
                    continue;
                endif; ?>
                    <div class="col-span-12 md:col-span-{{ $widget->mdColSize() }} lg:col-span-{{ $widget->colSize() }} widget widget-{{ $widget->widget->value }}" id="widget-col-{{ $widget->id }}">
                        @include('dashboard.widgets._' . $widget->widget->value)
                    </div>
            @endforeach

        </div>

        @can('dashboard', $campaign)
            <div class="my-5 text-center">
                <a href="{{ route('dashboard.setup', !empty($dashboard) ? [$campaign, 'dashboard' => $dashboard->id] : [$campaign]) }}" class="btn2 flex gap-1" title="{{ __('dashboard.settings.title') }}">
                    <x-icon class="cog" />
                    {{ __('dashboard.actions.customise') }}
                </a>
            </div>
        @endcan

    </div>
@endsection

@section('scripts')

    @vite('resources/js/dashboard.js')

    @if ($hasMap)
    <script src="{{ 'https://unpkg.com/leaflet@' . config('app.leaflet_source') . '/dist/leaflet.js' }}" integrity="{{ config('app.leaflet_js') }}" crossorigin=""></script>
    <script src="{{ config('app.asset_url') }}/vendor/leaflet/leaflet.markercluster.js"></script>
    <script src="{{ config('app.asset_url') }}/vendor/leaflet/leaflet.markercluster.layersupport.js"></script>
    <script src="{{ config('app.asset_url') }}/vendor/leaflet/leaflet.zoomdisplay.js"></script>
    <script src="{{ config('app.asset_url') }}/vendor/leaflet/leaflet.zoomcss.js"></script>
    @endif
@endsection

@section('styles')
    @if ($hasMap)
    <link rel="stylesheet" href="{{ 'https://unpkg.com/leaflet@' . config('app.leaflet_source') . '/dist/leaflet.css' }}" integrity="{{ config('app.leaflet_css') }}" crossorigin="" />
    @endif

    @vite([
        'resources/sass/dashboard.scss',
        'resources/sass/map-v3.scss'
    ])
@endsection

@section('modals')
    @can('apply', $campaign)
    <x-dialog id="apply-dialog" title="Loading"></x-dialog>
    @endif
@endsection
