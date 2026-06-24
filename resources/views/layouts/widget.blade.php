<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\Entity $entity
 */
$seoTitle = isset($seoTitle) ? $seoTitle : (isset($title) ? $title : null);
$showSidebar = (!empty($sidebar) && $sidebar === 'settings') || !empty($campaign);
$themeOverride = request()->get('_theme');
if (!empty($themeOverride) && in_array($themeOverride, ['dark', 'midnight', 'base'])) {
    $specificTheme = ($themeOverride === 'base') ? 'light' : $themeOverride;
} elseif (!empty($campaign) && $campaign->boosted() && !empty($campaign->theme_id)) {
    $specificTheme = match ($campaign->theme_id) {
        2 => 'dark',
        3 => 'midnight',
        default => 'light',
    };
} elseif (auth()->check() && !empty(auth()->user()->theme)) {
    $specificTheme = auth()->user()->theme;
} else {
    $specificTheme = 'light';
}
?><!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="scroll-pt-16 overflow-auto">
<head>
    <meta charset="utf-8">
    <title>{!! $seoTitle !!}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta property="og:title" content="{!! $seoTitle !!} - {{ config('app.name') }}" />
    <meta property="og:site_name" content="{{ config('app.site_name') }}" />
    @vite([
        'resources/css/vendor.css',
        'resources/css/app.css',
    ])
    @includeWhen(!config('fontawesome.kit'), 'layouts.styles.fontawesome')
    @yield('styles')
    @include('layouts._theme_css')
    @includeWhen(!empty($campaign), 'layouts._theme')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto&display=swap">
</head>
{{-- Hide the sidebar if the there is no current campaign --}}
<body class="@if(isset($entity)){{ $entity->bodyClasses() }}@endif @if(isset($bodyClass)){{ $bodyClass }}@endif @if (!empty($campaign) && auth()->check() && auth()->user()->can('admin', $campaign)) is-admin @endif @if(!app()->isProduction()) env-{{ app()->environment() }} @endif " data-theme="{{ $specificTheme }}" @if (!empty($campaign)) data-user-member="{{ auth()->check() && auth()->user()->can('member', $campaign) ? 1 : 0 }}" @endif>

    <div id="app" class="wrapper ">
        <div class="content-wrapper">
            <section class="" role="main">
                @yield('content')
            </section>
        </div>
    </div>

    @yield('modals')

    @includeWhen(config('fontawesome.kit'), 'layouts.scripts.fontawesome')
    @vite(['resources/js/vendor-final.js', 'resources/js/app.js'])
    @yield('scripts')
</body>
</html>
