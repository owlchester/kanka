<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\MiscModel $miscModel
 */
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
    <meta content='width=device-width, initial-scale=1, maximum-scale=5' name='viewport'>
    <meta property="og:title" content="{!! $seoTitle !!} - {{ config('app.name') }}" />
    <meta property="og:site_name" content="{{ config('app.site_name') }}" />
@if (isset($canonical))
    <link rel="canonical" href="{{ request()->fullUrl() }}" />
@endif
@foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
    @if (in_array($localeCode, ['hr', 'he', 'gl', 'hu', 'ca', 'nl']))@continue @endif
    <link rel="alternate" href="{{ request()->fullUrl() . '?lang=' . $localeCode }}" hreflang="{{ $localeCode }}">
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

    @if (config('app.asset_url'))
        <link rel="dns-prefetch" href="{{ config('app.asset_url') }}">
    @endif
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="//www.googletagmanager.com">
    @vite([
        'resources/sass/vendor.scss',
        'resources/sass/app.scss',
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&display=swap">
    @livewireStyles
</head>
{{-- Hide the sidebar if the there is no current campaign --}}
<body class=" @if(\App\Facades\DataLayer::groupB())ab-testing-second @else ab-testing-first @endif @if(isset($miscModel) && !empty($miscModel->entity)){{ $miscModel->bodyClasses($entity ?? null) }}@endif @if(isset($dashboard))dashboard-{{ $dashboard->id }}@endif @if(isset($bodyClass)){{ $bodyClass }}@endif @if (!empty($campaign) && auth()->check() && auth()->user()->isAdmin()) is-admin @endif @if(!app()->isProduction()) env-{{ app()->environment() }} @endif @if(!$showSidebar) sidebar-collapse @endif" @if(!empty($specificTheme)) data-theme="{{ $specificTheme }}" @endif @if (!empty($campaign)) data-user-member="{{ auth()->check() && $campaign->userIsMember() ? 1 : 0 }}" @endif>
@include('layouts.tracking.fallback')

<a href="#{{ isset($contentId) ? $contentId : "main-content" }}" class="skip-nav-link absolute mx-2 top-0 btn2 btn-primary btn-sm rounded-t-none" tabindex="1">
    {{ __('crud.navigation.skip_to_content') }}
</a>
    <div id="app" class="wrapper h-full min-h-screen relative mt-12">
        @include('layouts.header', ['toggle' => $showSidebar])
        @includeWhen(isset($campaign) || isset($sidebar) && $sidebar == 'settings', 'layouts.sidebars.' . ($sidebar ?? 'app'))

        <div class="content-wrapper" id="{{ isset($contentId) ? $contentId : "main-content" }}">
            @include('layouts.banner')

            @if(!view()->hasSection('content-header') && (isset($breadcrumbs) && $breadcrumbs !== false))
                <section class="content-header p-4 pb-0 @if (isset($centered) && $centered) max-w-7xl mx-auto @endif">
                    @includeWhen(!isset($breadcrumbs) || $breadcrumbs !== false, 'layouts._breadcrumbs')
                    @if (!view()->hasSection('entity-header'))
                        @if (isset($mainTitle))
                        @else
                            <h1 class="truncate m-0 text-lg">
                                {!! $title ?? "Page Title" !!}
                            </h1>
                        @endif
                    @endif
                </section>
            @endif

            @yield('content-header')

            <section class="content p-4 flex flex-col gap-2 lg:flex-gap-5 @if (isset($centered) && $centered) max-w-7xl mx-auto  @endif" role="main">
                @if (auth()->check() && \App\Facades\Identity::isImpersonating())
                    <div class=" alert p-4 rounded alert-warning border-0 shadow-xs flex flex-col lg:flex-row items-center gap-2 lg:gap-5">
                        <div class="grow">
                            <div class="m-0 p-0 text-lg">
                                <i class="icon fa-solid fa-exclamation-triangle" aria-hidden="true"></i>
                                {{ __('campaigns.members.impersonating.title', ['name' => auth()->user()->name]) }}
                            </div>
                            <p class="text-justify">
                                {{ __('campaigns.members.impersonating.message') }}
                            </p>
                        </div>
                        <a href="{{ route('identity.back', $campaign) }}" class="btn2 btn-sm switch-back">
                            <x-icon class="fa-solid fa-sign-out-alt" />
                            {{ __('campaigns.members.actions.switch-back') }}
                        </a>
                    </div>
                @endif
                @include('partials.success')

                @yield('entity-header')

                @yield('content')
            </section>
            <div class="absolute bottom-0 right-0 p-4 hidden back-to-top">
                <a href="#{{ isset($contentId) ? $contentId : "main-content" }}" class="flex items-center gap-1">
                    <x-icon class="fa-solid fa-arrow-up" />
                    Back to top
                </a>
            </div>
        </div>


        @include('layouts.footer')

    </div>

    <x-dialog id="primary-dialog" :loading="true" />
    <div id="dialog-backdrop" class="z-[1000] fixed top-0 left-0 right-0 bottom-0 h-full w-full backdrop-blur-sm bg-base-100 hidden" style="--tw-bg-opacity: 0.2"></div>

    @yield('modals')

    <div class="toast-container fixed overflow-y-auto overflow-x-hidden bottom-4 right-4 max-h-full flex flex-col gap-2"></div>

@if (config('fontawesome.kit'))
    <script src="https://kit.fontawesome.com/{{ config('fontawesome.kit') }}.js" crossorigin="anonymous"></script>
@endif
    @vite(['resources/js/vendor-final.js', 'resources/js/app.js', 'resources/js/cookieconsent.js'])
    @yield('scripts')

@includeWhen(config('tracking.consent'), 'partials.cookieconsent')
@livewireScripts
</body>
</html>
