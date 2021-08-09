<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\MiscModel $miscModel
 */
$campaign = CampaignLocalization::getCampaign(); ?>
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" @if(app()->getLocale() == 'he') dir="rtl" @endif>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{!! $title ?? '' !!} - {{ config('app.name', 'Kanka') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta property="og:title" content="{{ $title ?? '' }} - {{ config('app.name') }}" />
    <meta property="og:site_name" content="{{ config('app.site_name') }}" />

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

    <!-- Styles -->
    <link href="{{ mix('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ mix('css/vendor.css') }}" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link href="{{ mix('css/freyja.css') }}" rel="stylesheet">
@if(app()->getLocale() == 'he')
    <link href="{{ mix('css/app-rtl.css') }}" rel="stylesheet">
@endif
    <link href="{{ mix('css/print.css') }}" rel="stylesheet">
@yield('styles')

@if (request()->has('_theme') && in_array(request()->get('_theme'), ['dark', 'midnight', 'future', 'base']))
    @if(request()->get('_theme') != 'base')
    <link href="{{ mix('css/' . request()->get('_theme') . '.css') }}" rel="stylesheet">
    @endif
@else
    @if (!empty($campaign) && $campaign->boosted() && !empty($campaign->theme))
    @if ($campaign->theme_id !== 1)
        <link href="{{ mix('css/' . $campaign->theme->name . '.css') }}" rel="stylesheet">
    @endif
    @elseif (auth()->check() && !empty(auth()->user()->theme))
        <link href="{{ mix('css/' . auth()->user()->theme . '.css') }}" rel="stylesheet">
    @endif
@endif

@if(!empty($campaign) && $campaign->boosted() && $campaign->hasPluginTheme())
    <link href="{{ route('campaign_plugins.css', ['ts' => $campaign->updated_at->getTimestamp()]) }}" rel="stylesheet">
@endif
@if (!empty($campaign) && $campaign->boosted() && !empty($campaign->css))
    <link href="{{ route('campaign.css', ['ts' => $campaign->updated_at->getTimestamp()]) }}" rel="stylesheet">
@endif
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
</head>
{{-- Hide the sidebar if the there is no current campaign --}}
<body class="skin-black sidebar-mini @if (!empty($campaign) || (auth()->check() && auth()->user()->hasCampaigns()) || (!empty($sidebar) && $sidebar == 'settings'))@else layout-top-nav @endif @if(isset($miscModel) && !empty($miscModel->entity)){{ $miscModel->bodyClasses() }}@endif @if(isset($dashboard))dashboard-{{ $dashboard->id }}@endif @if(isset($bodyClass)){{ $bodyClass }}@endif">
@include('layouts._tracking-fallback')
    <div id="app" class="wrapper">

        <div class="content-wrapper" @if(isset($contentId)) id="{{ $contentId }}" @endif>
            @if(!view()->hasSection('content-header'))
            <section class="content-header">
                @if (!isset($breadcrumbs) || $breadcrumbs !== false)
                <ol class="breadcrumb">
                @if (!isset($breadcrumbsDashboard) || $breadcrumbsDashboard === true)
                    @if ($campaign)
                        <li>
                            <a href="{{ route('dashboard') }}">
                                <i class="fa fa-globe"></i>
                                <span class="hidden-xs hidden-sm">
                                    {!! $campaign->name !!}
                                </span>
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('home') }}">
                                <i class="fa fa-dashboard"></i>
                                <span class="hidden-xs hidden-sm">
                                    {{ __('dashboard.title') }}
                                </span>
                            </a>
                        </li>
                    @endif
                @endif
                    @if (isset($breadcrumbs))
                        @foreach ($breadcrumbs as $breadcrumb)
                            <li>
                                @if (!empty($breadcrumb['url']))
                                    <a href="{{ $breadcrumb['url'] }}" title="{{ $breadcrumb['label'] }}">
                                        @if (strlen($breadcrumb['label']) > 22)
                                            {{ substr($breadcrumb['label'], 0, 20) . '...' }}
                                        @else
                                            {{ $breadcrumb['label'] }}
                                        @endif
                                    </a>
                                @else
                                    @if (strlen($breadcrumb) > 22)
                                        <span title="{{ $breadcrumb }}">{{ substr($breadcrumb, 0, 20) . '...' }}</span>
                                    @else
                                        {{ $breadcrumb }}
                                    @endif
                                @endif
                            </li>
                        @endforeach
                    @endif
                </ol>
                @endif

                @if (!View::hasSection('entity-header'))
                    @if (isset($mainTitle))
                        @yield('header-extra')
                    @else
                        <h1>
                            @yield('header-extra')
                            {!! $title ?? "Page Title" !!}
                            <small class="hidden-xs hidden-sm">{{ $description ?? null }}</small>
                        </h1>
                    @endif
                @endif
            </section>
            @endif

            @yield('content-header')

            <section class="content">
                @if (auth()->check() && \App\Facades\Identity::isImpersonating())
                    <div class="alert alert-warning">
                        <h4>
                            <i class="icon fa fa-exclamation-triangle"></i>
                            {{ __('campaigns.members.impersonating.title', ['name' => auth()->user()->name]) }}
                        </h4>
                        <p>
                            {{ __('campaigns.members.impersonating.message') }}

                            <a href="{{ route('identity.back') }}" class="btn btn-warning btn-sm">
                                <i class="fa fa-sign-out-alt"></i> {{ trans('campaigns.members.actions.switch-back') }}
                            </a>
                        </p>
                    </div>
                @endif
                @include('partials.success')

@if(!empty(config('tracking.adsense')) && (auth()->guest() || auth()->user()->showAds()) && !isset($skipBannerAd) && (!isset($sidebar) || $sidebar != 'settings'))
                <p class="text-center text-muted">
                    {!! __('misc.ads.remove_v2', [
    'supporting' => link_to_route('settings.subscription', __('misc.ads.supporting'), [], ['target' => '_blank']),
    'boosting' => link_to_route('front.pricing', __('misc.ads.boosting'), ['#boost'], ['target' => '_blank']),
    ]) !!}
                </p>
@endif

                @yield('entity-actions')
                @yield('entity-header')
                @yield('content')
            </section>
        </div>

    </div>

    <script src="https://kit.fontawesome.com/d7f0be4a8d.js" crossorigin="anonymous"></script>
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="/js/select2/i18n/{{ LaravelLocalization::getCurrentLocale() == 'en-US' ? 'en' : LaravelLocalization::getCurrentLocale() }}.js" defer></script>
    @yield('scripts')
</body>
</html>
