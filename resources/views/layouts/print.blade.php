<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\Entity $entity
 */
$themeOverride = request()->get('_theme', 'base');
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
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <title>{!! $title ?? '' !!}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=5' name='viewport'>
    <meta property="og:title" content="{{ $title ?? '' }}" />
    <meta property="og:site_name" content="{{ config('app.site_name') }}" />

    @include('layouts.links.icons')
    @vite([
        'resources/css/vendor.css',
        'resources/css/app.css',
    ])
    @includeWhen(!config('fontawesome.kit'), 'layouts.styles.fontawesome')
    @yield('styles')
    @include('layouts._theme_css')
    @includeWhen(!empty($campaign), 'layouts._theme')
    @vite([
    'resources/css/print/print.css',
    ])
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto&display=swap">
</head>

<body class="{{ $entity->bodyClasses() }}  @if(isset($bodyClass)){{ $bodyClass }}@endif" data-theme="{{ $specificTheme }}">
    <div id="app" class="wrapper">

        <div class="content-wrapper" @if(isset($contentId)) id="{{ $contentId }}" @endif>
            @if(!view()->hasSection('content-header'))
            <section class="content-header">
                @includeWhen(!isset($breadcrumbs) || $breadcrumbs !== false, 'layouts._breadcrumbs')

                @if (!View::hasSection('entity-header'))
                    @if (isset($mainTitle))
                    @else
                        <h1>
                            {!! $title ?? "Page Title" !!}
                        </h1>
                    @endif
                @endif
            </section>
            @endif

            @yield('content-header')

            <section class="content">
                @include('partials.success')
                @yield('entity-header')
                @yield('content')
            </section>
        </div>

    </div>

    @includeWhen(config('fontawesome.kit'), 'layouts.scripts.fontawesome')
    @vite(['resources/js/vendor-final.js', 'resources/js/app.js'])
    @yield('scripts')
</body>
</html>
