<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\Entity $entity
 */
$themeOverride = request()->get('_theme');
$specificTheme = null;
$seoTitle = isset($seoTitle) ? $seoTitle : (isset($title) ? $title : null);
$showSidebar = (!empty($sidebar) && $sidebar === 'settings') || !empty($campaign);
$sidebarCollapsed = Cookie::get('toggleState') === 'collapsed';
$cleanCanonical = \Illuminate\Support\Str::before(request()->fullUrl(), '%3');

?><!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="scroll-pt-16 overflow-auto">
<head>
@include('layouts.tracking.tracking')
    <meta charset="utf-8">
    <title>{!! $seoTitle !!}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=5' name='viewport'>
    <meta property="og:title" content="{!! $seoTitle !!}" />
    <meta property="og:site_name" content="{{ config('app.site_name') }}" />
    <link rel="canonical" href="{{ $cleanCanonical }}" />


    @yield('og')
    @include('layouts.links.icons')
    @if (config('app.asset_url'))
        <link rel="dns-prefetch" href="{{ config('app.asset_url') }}">
    @endif
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="//www.googletagmanager.com">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite([
        'resources/sass/vendor.scss',
        'resources/sass/app.scss',
    ])
    @if (!config('fontawesome.kit'))<link href="/vendor/fontawesome/6.0.0/css/all.min.css" rel="stylesheet">@endif
    @includeWhen (config('ads.freestar.enabled'), 'ads.freestar.styles')
    @yield('styles')
    @if (!empty($themeOverride) && in_array($themeOverride, ['dark', 'midnight', 'base']))
        @php $specificTheme = $themeOverride; @endphp
        @if($themeOverride != 'base')

    @vite('resources/sass/themes/' . $themeOverride . '.scss')
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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    @livewireStyles
</head>
{{-- Hide the sidebar if the there is no current campaign --}}
<body class=" @if(\App\Facades\DataLayer::groupB())ab-testing-second @else ab-testing-first @endif
@if(isset($entity)){{ $entity->bodyClasses() }}@endif
@if(isset($dashboard))dashboard-{{ $dashboard->id }}@endif @if(isset($bodyClass)){{ $bodyClass }}@endif @if (!empty($campaign) && auth()->check() && auth()->user()->isAdmin()) is-admin @endif @if(!app()->isProduction()) env-{{ app()->environment() }} @endif @if(!$showSidebar || $sidebarCollapsed) sidebar-collapse @endif antialiased" @if(!empty($specificTheme)) data-theme="{{ $specificTheme }}" @endif @if (!empty($campaign)) data-user-member="{{ auth()->check() && $campaign->userIsMember() ? 1 : 0 }}" @endif >

<a href="#{{ isset($contentId) ? $contentId : "main-content" }}" class="skip-nav-link absolute mx-2 top-0 btn2 btn-primary btn-sm rounded-t-none" tabindex="0">
    {{ __('crud.navigation.skip_to_content') }}
</a>
    <div id="app" class="wrapper h-full min-h-screen relative mt-12">
        @include('layouts.header', ['toggle' => $showSidebar])
        @includeWhen(isset($campaign) || (isset($sidebar) && $sidebar === 'settings'), 'layouts.sidebars.' . ($sidebar ?? 'app'))

        <div class="content-wrapper transition-all duration-150" id="{{ isset($contentId) ? $contentId : "main-content" }}">
            @includeWhen(!isset($skipBanners), 'layouts.banner')

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
                @includeWhen (auth()->check() && \App\Facades\Identity::isImpersonating(), 'partials.impersonate')
                @include('partials.success')

                @yield('entity-header')

                @yield('content')
            </section>
            <div class="absolute bottom-0 right-0 p-4 hidden back-to-top">
                <a href="#{{ isset($contentId) ? $contentId : "main-content" }}" class="flex items-center gap-1">
                    <x-icon class="fa-regular fa-arrow-up" />
                    Back to top
                </a>
            </div>
        </div>

        @include('ads.incontent')
        @include('layouts.footer')
    </div>

    <x-dialog id="primary-dialog" :loading="true" />
    <div id="dialog-backdrop" class="z-[1000] fixed top-0 left-0 right-0 bottom-0 h-full w-full backdrop-blur-sm bg-base-100 hidden" style="--tw-bg-opacity: 0.2"></div>

    @include('layouts.dialogs.languages')
    @yield('modals')

    <div class="toast-container fixed overflow-y-auto overflow-x-hidden bottom-4 right-4 max-h-full flex flex-col gap-2 z-[1001]"></div>

@if (config('fontawesome.kit'))
    <script src="https://kit.fontawesome.com/{{ config('fontawesome.kit') }}.js" crossorigin="anonymous"></script>
@endif
    @vite(['resources/js/vendor-final.js', 'resources/js/app.js', 'resources/js/cookieconsent.js'])
    @yield('scripts')

@includeWhen(config('tracking.consent'), 'partials.cookieconsent')
@livewireScripts
</body>
</html>
