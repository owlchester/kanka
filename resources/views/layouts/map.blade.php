<?php /**
 * @var \App\Models\Map $map
 */
$campaign = CampaignLocalization::getCampaign();
$themeOverride = request()->get('_theme');
$specificTheme = null;
?><!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('layouts._tracking', ['noads' => true])
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $title ?? __('default.page_title') }} - {{ config('app.name') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta property="og:title" content="{{ $title ?? '' }} - {{ config('app.name') }}" />
    <meta property="og:site_name" content="{{ config('app.site_name') }}" />
    @yield('og')

    <link rel="shortcut icon" href="/images/favicon/favicon.ico" type="image/x-icon" />
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicon/favicon-16x16.png">
    <link rel="apple-touch-icon" href="/images/favicon/apple-touch-icon.png" />
    <link rel="apple-touch-icon" sizes="57x57" href="/images/favicon/apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon" sizes="72x72" href="/images/favicon/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon" sizes="76x76" href="/images/favicon/apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon" sizes="114x114" href="/images/favicon/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon" sizes="120x120" href="/images/favicon/apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon" sizes="144x144" href="/images/favicon/apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon" sizes="152x152" href="/images/favicon/apple-touch-icon-152x152.png" />
    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicon/apple-touch-icon-180x180.png" />

    <link href="/css/bootstrap.css?v={{ config('app.version') }}" rel="stylesheet">

    @vite([
        'resources/sass/vendor.scss',
        'resources/sass/app.scss',
        'resources/sass/freyja/freyja.scss',
        'resources/sass/map-v3.scss',
    ])
    @if (!config('fontawesome.kit'))<link href="/vendor/fontawesome/6.0.0/css/all.min.css" rel="stylesheet">@endif
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.2/dist/leaflet.css" integrity="sha256-sA+zWATbFveLLNqWO2gtiw3HL/lh1giY/Inf1BJ0z14=" crossorigin="" />

    @include('layouts._theme')
@yield('styles')
</head>
<body id="map-body" class="map-page sidebar-collapse @if(\App\Facades\DataLayer::groupB())ab-testing-second @else ab-testing-first @endif @if (!empty($campaign) && auth()->check() && auth()->user()->isAdmin()) is-admin @endif" @if(!empty($specificTheme)) data-theme="{{ $specificTheme }}" @endif>
@include('layouts._tracking-fallback')

    <div id="app" class="wrapper mt-12">
        <!-- Header -->
        @include('layouts.header', ['qq' => false])

        <aside class="main-sidebar overflow-hidden pt-0">
            <section class="sidebar" style="height: auto">

                <div id="sidebar-content" class="p-0 overflow-auto max-h-screen">
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
                            @can('update', $map)
                                <div class="btn-group">
                                    <a href="{{ route('maps.edit', [$map]) }}" class="btn btn-primary">
                                        <i class="fa-solid fa-map" aria-hidden="true"></i> {{ __('maps.actions.edit') }}
                                    </a>
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li>
                                            <a href="{{ route('maps.map_layers.index', [$map]) }}" class="dropdown-item">
                                                <i class="fa-solid fa-layer-group" aria-hidden="true"></i> {{ __('maps.panels.layers') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('maps.map_groups.index', [$map]) }}" class="dropdown-item">
                                                <i class="fa-solid fa-map-signs" aria-hidden="true"></i> {{ __('maps.panels.groups') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('maps.map_markers.index', [$map]) }}" class="dropdown-item">
                                                <i class="fa-solid fa-map-pin" aria-hidden="true"></i> {{ __('maps.panels.markers') }}
                                            </a>
                                        </li>
                                    </ul>
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
                            <a href="{{ $map->getLink() }}" class="btn btn-primary">{{ __('maps.actions.back', ['name' => $map->name]) }}</a>
                        </div>
                    </div>

                    <!-- When clicking on a marker, this menu pops up -->
                    <div id="sidebar-marker"></div>
                    <div class="spinner text-center" style="display: none; margin-top: 10px;">
                        <i class="fa-solid fa-spinner fa-spin fa-2x"></i>
                    </div>
                </div>

            </section>
        </aside>

        <div class="content-wrapper">
        @yield('content')
        </div>
    </div>

    <div class="toast-container fixed overflow-y-auto overflow-x-hidden bottom-4 right-4 max-h-full"></div>

    <!-- Modal -->
    @includeWhen(auth()->check(), 'layouts.modals.delete')

<script src="/js/vendor.js"></script>
@vite('resources/js/app.js')
@if (config('fontawesome.kit'))
    <script src="https://kit.fontawesome.com/{{ config('fontawesome.kit') }}.js" crossorigin="anonymous"></script>
@endif
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.9.2/dist/leaflet.js" integrity="sha256-o9N1jGDZrf5tS+Ft4gbIK7mYMipq9lqpVJ91xHSyKhg=" crossorigin=""></script>
<script src="/js/vendor/leaflet/leaflet.markercluster.js"></script>
<script src="/js/vendor/leaflet/leaflet.markercluster.layersupport.js"></script>
<script src="/js/vendor/leaflet/leaflet.zoomcss.js"></script>
@if ($map->isReal())
<script src="/js/vendor/leaflet/leaflet.ruler.js"></script>
@else
    <script src="/js/vendor/leaflet/leaflet.ruler-kanka.js"></script>
@endif

@vite('resources/js/location/map-v3.js')
@yield('scripts')

@yield('modals')
</body>
</html>
