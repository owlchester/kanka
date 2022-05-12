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

    <link href="{{ mix('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ mix('css/vendor.css') }}" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/freyja.css') }}" rel="stylesheet">
    <link href="{{ mix('css/map-v3.css') }}" rel="stylesheet">
    @if (!config('fontawesome.kit'))<link href="/vendor/fontawesome/6.0.0/css/all.min.css" rel="stylesheet">@endif
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
          integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
          crossorigin=""/>
    <link rel="stylesheet" href="https://ppete2.github.io/Leaflet.PolylineMeasure/Leaflet.PolylineMeasure.css" />

@if (!empty($themeOverride) && in_array($themeOverride, ['dark', 'midnight', 'base']))
    @php $specificTheme = $themeOverride; @endphp
    @if(request()->get('_theme') != 'base')
        <link href="{{ mix('css/' . request()->get('_theme') . '.css') }}" rel="stylesheet">
    @endif
@else
    @if (!empty($campaign) && $campaign->boosted() && !empty($campaign->theme))
        @if ($campaign->theme_id !== 1)
            <link href="{{ mix('css/' . $campaign->theme->name . '.css') }}" rel="stylesheet">
            @php $specificTheme = $campaign->theme->name @endphp
        @endif
    @elseif (auth()->check() && !empty(auth()->user()->theme))
        <link href="{{ mix('css/' . auth()->user()->theme . '.css') }}" rel="stylesheet">
        @php $specificTheme = auth()->user()->theme @endphp
    @endif
@endif
@if(!empty($campaign) && $campaign->boosted() && $campaign->hasPluginTheme())
    <link href="{{ route('campaign_plugins.css', ['ts' => $campaign->updated_at->getTimestamp()]) }}" rel="stylesheet">
@endif
@if (!empty($campaign) && $campaign->boosted())
    <link href="{{ route('campaign.css', ['ts' => \App\Facades\CampaignCache::stylesTimestamp()]) }}" rel="stylesheet">
@endif
@yield('styles')
</head>
<body id="map-body" class="map-page skin-black skin-map sidebar-mini sidebar-collapse" @if(!empty($specificTheme)) data-theme="{{ $specificTheme }}" @endif>
@include('layouts._tracking-fallback')

    <div id="app" class="wrapper">
        <!-- Header -->
        @include('layouts.header')

        <aside class="main-sidebar">
            <section class="sidebar" style="height: auto">

                <div id="sidebar-content">
                    <div id="sidebar-map">
                        <div class="marker-details">
                            <h3 class="marker-name">{{ $map->name }}</h3>
                            <div class="marker-entry">{!! \App\Facades\Mentions::map($map) !!}</div>
                        </div>

                        <div class="marker-actions text-center">
                            @can('update', $map)
                                <a href="{{ route('maps.edit', [$map]) }}" class="btn btn-primary">
                                    <i class="fa-solid fa-map"></i> {{ __('maps.actions.edit') }}
                                </a>
                            @endcan
                        </div>


                        <div class="map-legend">
                            @include('maps.explore.legend')
                        </div>

                        <div class="map-legend text-center">
                            <a href="{{ $map->getLink() }}" class="btn btn-primary">{{ __('maps.actions.back', ['name' => $map->name]) }}</a>
                        </div>
                    </div>
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

    <!-- Modal -->
    <div class="modal fade" id="delete-confirm" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ __('crud.delete_modal.title') }}</h4>
                </div>
                <div class="modal-body">
                    <p>
                        {!! __('crud.delete_modal.description_v2', ['tag' => '<b><span id="target-name"></span></b>']) !!}
                    </p>
                    <div id="delete-confirm-mirror" class="form-group" style="display: none">
                        <label>
                            <input type="checkbox" id="delete-confirm-mirror-chexkbox" name="delete-mirror">
                            {{ __('crud.delete_modal.mirrored') }}
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('crud.cancel') }}</button>
                    <button type="button" class="btn btn-danger delete-confirm-submit"><span class="fa-solid fa-trash"></span> {{ __('crud.delete_modal.delete') }}</button>
                </div>
            </div>
        </div>
    </div>

<script src="{{ mix('js/app.js') }}"></script>
@if (config('fontawesome.kit'))
    <script src="https://kit.fontawesome.com/{{ config('fontawesome.kit') }}.js" crossorigin="anonymous"></script>
@endif
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
        integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
        crossorigin=""></script>
<script src="/js/vendor/leaflet/leaflet-polyline-measure.js"></script>

<script src="{{ mix('js/location/map-v3.js') }}" defer></script>
@yield('scripts')

@yield('modals')
</body>
</html>
