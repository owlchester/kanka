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
    <meta property="og:description" content="{{ $campaign->preview() }}" />
    @if ($campaign->image)<meta property="og:image" content="{{ Img::crop(50, 50)->url($campaign->image)  }}" />@endif
    <meta property="og:url" content="{{ route('campaigns.show', $campaign)  }}" />
@endsection

@section('content')
    <div class="max-w-7xl mx-auto">
        @if (empty($dashboard))
            @include('dashboard.widgets._campaign')
        @endif

        @include('partials.ads.top')

        <div class="dashboard-widgets grid grid-cols-12 gap-2 md:gap-5">
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
                    <div class="col-span-12 md:col-span-{{ $widget->colSize() }} widget widget-{{ $widget->widget->value }}" id="widget-col-{{ $widget->id }}">
                        @include('dashboard.widgets._' . $widget->widget->value)
                    </div>
            @endforeach
        </div>

        @can('dashboard', $campaign)
            <div class="text-center mt-6">
                <a href="{{ route('dashboard.setup', !empty($dashboard) ? [$campaign, 'dashboard' => $dashboard->id] : [$campaign]) }}" class="btn2 btn-lg btn-primary" title="{{ __('dashboard.settings.title') }}">
                    <x-icon class="cog"></x-icon>
                    {{ __('dashboard.settings.title') }}
                </a>
            </div>

            @if($widgets->count() === 0)
                <div class="mt-6"></div>
                <x-alert type="info">
                    <p>
                    {!! __('dashboard.setup.tutorial.text', [
        'blog' => link_to('https://blog.kanka.io/2020/09/20/how-to-style-your-kanka-campaign-dashboard/', __('dashboard.setup.tutorial.blog'), ['target' => '_blank'])
    ]) !!}
                    </p>
                </x-alert>
            @endif
        @endcan
    </div>
@endsection

@section('scripts')

    @vite('resources/js/dashboard.js')

    @if ($hasMap)
    <script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js" integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg=" crossorigin=""></script>
    <script src="{{ config('app.asset_url') }}/vendor/leaflet/leaflet.markercluster.js"></script>
    <script src="{{ config('app.asset_url') }}/vendor/leaflet/leaflet.markercluster.layersupport.js"></script>
    @endif
@endsection

@section('styles')
    @if ($hasMap)
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css" integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />
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
