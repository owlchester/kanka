<?php /**
 * @var \App\Models\Map $map
 */
$themeOverride = request()->get('_theme');
$specificTheme = null;
?><!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('layouts.tracking.tracking')
    <meta charset="utf-8">
    <title>{{ $title ?? __('default.page_title') }} - {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta property="og:title" content="{{ $title ?? '' }} - {{ config('app.name') }}" />
    <meta property="og:site_name" content="{{ config('app.site_name') }}" />
    @yield('og')
    @include('layouts.links.icons')

    @vite([
        'resources/css/vendor.css',
        'resources/sass/app.scss',
        'resources/css/maps/maps.css'
    ])
    @if (!config('fontawesome.kit'))<link href="/vendor/fontawesome/6.0.0/css/all.min.css" rel="stylesheet">@endif
    <link rel="stylesheet" href="{{ 'https://unpkg.com/leaflet@' . config('app.leaflet_source') . '/dist/leaflet.css' }}" integrity="{{ config('app.leaflet_css') }}" crossorigin="" />
    @if (!empty($themeOverride) && in_array($themeOverride, ['dark', 'midnight', 'base']))
        @php $specificTheme = $themeOverride; @endphp
        @if($themeOverride != 'base')
            @vite('resources/sass/themes/' . request()->get('_theme') . '.scss')
        @endif
    @else
        @if (!empty($campaign) && $campaign->boosted() && !empty($campaign->theme_id))
            @if ($campaign->theme_id !== 1)
                @vite('resources/sass/themes/' . ($campaign->theme_id === 2 ? 'dark' : 'midnight') . '.scss')
                @php $specificTheme = ($campaign->theme_id === 2 ? 'dark' : 'midnight') @endphp
            @endif
        @elseif (auth()->check() && !empty(auth()->user()->theme))
            @vite('resources/sass/themes/' . auth()->user()->theme . '.scss')
            @php $specificTheme = auth()->user()->theme @endphp
        @endif
    @endif
    <link rel="stylesheet" href="{{ config('app.asset_url') }}/vendor/leaflet/leaflet.layerstree.css"/>
    @includeWhen(!empty($campaign), 'layouts._theme')
@yield('styles')
</head>
<body id="map-body" class="map-page sidebar-collapse @if(\App\Facades\DataLayer::groupB())ab-testing-second @else ab-testing-first @endif @if (!empty($campaign) && auth()->check() && auth()->user()->isAdmin()) is-admin @endif" @if(!empty($specificTheme)) data-theme="{{ $specificTheme }}" @endif @if(isset($noHeader)) style="margin-bottom: -30px;" @endif>
@if (!isset($noHeader))
    <div id="app" class="wrapper h-full relative overflow-x-hidden overflow-y-auto mt-12">
        <!-- Header -->
        @includeWhen(!isset($noHeader), 'layouts.header', ['toggle' => true])
        <aside class="main-sidebar overflow-hidden absolute z-20 h-full flex flex-col">
            <section class="sidebar grow mb-20" style="height: auto">

                <div id="sidebar-content" class="p-0 overflow-auto h-sidebar">
                    <!-- The legend / overview default sidebar of the map -->
                    <div id="sidebar-map">
                        <div class="marker-header">
                            <div class="marker-header-lower">
                                <div class="marker-name text-2xl p-3">
                                    {{ $map->name }}
                                </div>
                            </div>
                        </div>

                        <div class="marker-entry px-3 entity-content">
                            {!! \App\Facades\Mentions::map($map) !!}
                        </div>

                        <div class="marker-actions text-center">
                            @can('update', $map->entity)
                                <div class="join">
                                    <a href="{{ route('maps.edit', [$campaign, $map]) }}" class="btn2 btn-primary btn-sm join-item">
                                        <x-icon class="map" /> {{ __('maps.actions.edit') }}
                                    </a>
                                    <div class="dropdown">
                                        <button type="button" class="btn2 btn-primary btn-sm join-item" data-dropdown aria-expanded="false">
                                            <x-icon class="fa-regular fa-caret-down" />
                                            <span class="sr-only">{{ __('crud.actions.actions') }}</span>
                                        </button>
                                        <div class="dropdown-menu hidden" role="menu">
                                            <x-dropdowns.item
                                                :link="route('maps.map_layers.index', [$campaign, $map])"
                                                icon="fa-regular fa-layer-group">
                                                {{ __('maps.panels.layers') }}
                                            </x-dropdowns.item>
                                            <x-dropdowns.item
                                                :link="route('maps.map_groups.index', [$campaign, $map])"
                                                icon="fa-regular fa-map-signs">
                                                {{ __('maps.panels.groups') }}
                                            </x-dropdowns.item>
                                            <x-dropdowns.item
                                                :link="route('maps.map_markers.index', [$campaign, $map])"
                                                icon="fa-regular fa-map-pin">
                                                {{ __('maps.panels.markers') }}
                                            </x-dropdowns.item>
                                        </div>
                                    </div>
                                </div>
                            @endcan
                        </div>


                        <div class="map-legend p-3">
                            @include('maps.explore.legend')
                        </div>
                        <div class="sidebar-menu" style="display: none">
                            <!-- used for the sidebar toggle plugin -->
                        </div>

                        <div class="map-legend text-center">
                            <a href="{{ $map->getLink() }}" class="btn2 btn-ghost btn-sm">{{ __('maps.actions.back', ['name' => $map->name]) }}</a>
                        </div>
                    </div>

                    <!-- When clicking on a marker, this menu pops up -->
                    <div id="sidebar-marker"></div>
                    <div class="spinner text-center text-lg" style="display: none; margin-top: 10px;">
                        <x-icon class="load" />
                    </div>
                </div>

            </section>
        </aside>

        <div class="content-wrapper">
        @yield('content')
        </div>
    </div>
    <x-dialog id="primary-dialog" :loading="true" />
    <div id="dialog-backdrop" class="z-[1000] fixed top-0 left-0 right-0 bottom-0 h-full w-full backdrop-blur-sm bg-base-100 hidden" style="--tw-bg-opacity: 0.2"></div>

    <div class="toast-container fixed overflow-y-auto overflow-x-hidden bottom-4 right-4 max-h-full"></div>
@else
    @yield('content')
@endif

@vite(['resources/js/vendor-final.js', 'resources/js/app.js'])
@if (config('fontawesome.kit'))
    <script src="https://kit.fontawesome.com/{{ config('fontawesome.kit') }}.js" crossorigin="anonymous"></script>
@endif
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="{{ 'https://unpkg.com/leaflet@' . config('app.leaflet_source') . '/dist/leaflet.js' }}" integrity="{{ config('app.leaflet_js') }}" crossorigin=""></script>
<script src="{{ config('app.asset_url') }}/vendor/leaflet/leaflet.zoomdisplay.js" type="text/javascript" ></script>
<script src="{{ config('app.asset_url') }}/vendor/leaflet/leaflet.markercluster.js"></script>
<script src="{{ config('app.asset_url') }}/vendor/leaflet/leaflet.markercluster.layersupport.js"></script>
<script src="{{ config('app.asset_url') }}/vendor/leaflet/leaflet.zoomcss.js"></script>
@if ($map->isReal())
<script src="{{ config('app.asset_url') }}/vendor/leaflet/leaflet.ruler.js"></script>
@else
    <script src="{{ config('app.asset_url') }}/vendor/leaflet/leaflet.ruler-kanka.js"></script>
@endif
<script src="{{ config('app.asset_url') }}/vendor/leaflet/leaflet.path.drag.js"></script>
<script src="{{ config('app.asset_url') }}/vendor/leaflet/leaflet.editable.js"></script>
<script src="{{ config('app.asset_url') }}/vendor/leaflet/leaflet.layerstree.js"></script>
@vite('resources/js/location/map-v3.js')
@yield('scripts')
@yield('modals')
@includeWhen(config('tracking.consent'), 'partials.cookieconsent')
</body>
</html>
