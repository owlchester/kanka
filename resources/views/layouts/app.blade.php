<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\MiscModel $miscModel
 */
$campaign = \App\Facades\CampaignLocalization::getCampaign();
$themeOverride = request()->get('_theme');
$specificTheme = null;
$seoTitle = isset($seoTitle) ? $seoTitle : (isset($title) ? $title : null);
$showSidebar = (!empty($sidebar) && $sidebar === 'settings') || !empty($campaign);
?><!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="scroll-pt-16 overflow-auto">
<head>
@include('layouts.tracking.tracking')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{!! $seoTitle !!} - {{ config('app.name', 'Kanka') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta property="og:title" content="{!! $seoTitle !!} - {{ config('app.name') }}" />
    <meta property="og:site_name" content="{{ config('app.site_name') }}" />
@if (isset($canonical))
    <link rel="canonical" href="{{ LaravelLocalization::localizeURL(null, $campaign->locale) }}" />
@endif
@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
    <link rel="alternate" href="{{ LaravelLocalization::localizeUrl(null, $localeCode) }}" hreflang="{{ $localeCode }}">
@endforeach

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

    <!-- Styles -->
    <link href="/css/bootstrap.css?v={{ config('app.version') }}" rel="stylesheet">
    @vite([
        'resources/sass/vendor.scss',
        'resources/sass/app.scss',
        'resources/sass/freyja/freyja.scss'
    ])
    @if (!config('fontawesome.kit'))<link href="/vendor/fontawesome/6.0.0/css/all.min.css" rel="stylesheet">@endif
    @yield('styles')
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
    @includeWhen(!empty($campaign), 'layouts._theme')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
</head>
{{-- Hide the sidebar if the there is no current campaign --}}
<body class=" @if(\App\Facades\DataLayer::groupB())ab-testing-second @else ab-testing-first @endif @if(isset($miscModel) && !empty($miscModel->entity)){{ $miscModel->bodyClasses($entity ?? null) }}@endif @if(isset($dashboard))dashboard-{{ $dashboard->id }}@endif @if(isset($bodyClass)){{ $bodyClass }}@endif @if (!empty($campaign) && auth()->check() && auth()->user()->isAdmin()) is-admin @endif @if(!app()->isProduction()) env-{{ app()->environment() }} @endif @if(!$showSidebar) sidebar-collapse @endif" @if(!empty($specificTheme)) data-theme="{{ $specificTheme }}" @endif @if (!empty($campaign)) data-user-member="{{ auth()->check() && $campaign->userIsMember() ? 1 : 0 }}" @endif>
@include('layouts.tracking.fallback')

<a href="#{{ isset($contentId) ? $contentId : "main-content" }}" class="skip-nav-link absolute py-2 px-4 top-0" tabindex="1">
    {{ __('crud.navigation.skip_to_content') }}
</a>
    <div id="app" class="wrapper mt-12">
        @include('layouts.header', ['toggle' => $showSidebar])

        @include('layouts.sidebars.' . ($sidebar ?? 'app'))

        @yield('fullpage-form')

        <div class="content-wrapper" id="{{ isset($contentId) ? $contentId : "main-content" }}">
            @include('layouts.banner')

            @if(!view()->hasSection('content-header') && (isset($breadcrumbs) && $breadcrumbs !== false))
                <section class="content-header">
                    @includeWhen(!isset($breadcrumbs) || $breadcrumbs !== false, 'layouts._breadcrumbs')
                    @if (!view()->hasSection('entity-header'))
                        @if (isset($mainTitle))
                            @yield('header-extra')
                        @else
                            <h1 class="truncate m-0 text-lg">
                                @yield('header-extra')
                                {!! $title ?? "Page Title" !!}
                                <small class="hidden-xs hidden-sm">{{ $description ?? null }}</small>
                            </h1>
                        @endif
                    @endif
                </section>
            @endif

            @yield('content-header')

            <section class="content" role="main">
                @if (isset($sidebar) && $sidebar === 'settings') <div class="max-w-4xl"> @endif
                @if (auth()->check() && \App\Facades\Identity::isImpersonating())
                    <div class=" alert p-4 rounded alert-warning border-0 shadow-xs flex flex-col lg:flex-row items-center gap-2 lg:gap-5 mb-5">
                        <div class="m-0 p-0 text-lg">
                            <i class="icon fa-solid fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ __('campaigns.members.impersonating.title', ['name' => auth()->user()->name]) }}
                        </div>
                        <div class="grow text-justify">
                            {{ __('campaigns.members.impersonating.message') }}
                        </div>
                        <div>
                            <a href="{{ route('identity.back') }}" class="btn btn-warning btn-sm switch-back">
                                <x-icon class="fa-solid fa-sign-out-alt"></x-icon>
                                {{ __('campaigns.members.actions.switch-back') }}
                            </a>
                        </div>
                    </div>
                @endif
                @include('partials.success')

                @yield('entity-actions')
                @yield('entity-header')
                @yield('content')

                @if (isset($sidebar) && $sidebar === 'settings') </div> @endif
            </section>
        </div>

        @yield('fullpage-form-end')

        @include('layouts.footer')

    </div>

    <!-- Default modal used throughout the app -->
    <div class="modal fade z-[9900]" id="entity-modal" role="dialog" tabindex="-1" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-2xl"></div>
            <div class="modal-spinner" style="display: none">
                <div class="modal-body text-center">
                    <i class="fa-solid fa-spinner fa-spin fa-2x" aria-hidden="true"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Extra-large modal on desktop for more data -->
    <div class="modal fade z-[9900]" id="large-modal" role="dialog" tabindex="-1" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content rounded-2xl" id="large-modal-content"></div>
        </div>
    </div>

    @includeWhen(auth()->check(), 'layouts.modals.delete')

    @yield('modals')

    <div class="toast-container fixed overflow-y-auto overflow-x-hidden bottom-4 right-4 max-h-full"></div>

@if (config('fontawesome.kit'))
    <script src="https://kit.fontawesome.com/{{ config('fontawesome.kit') }}.js" crossorigin="anonymous"></script>
@endif
    <script src="/js/vendor.js" defer></script>
    @vite('resources/js/app.js')
    @yield('scripts')
</body>
</html>
