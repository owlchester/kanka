<?php /**
 * @var \App\Models\Campaign $campaign
 */
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
        'resources/css/app.css',
    ])
    @includeWhen(!config('fontawesome.kit'), 'layouts.styles.fontawesome')
    @include('layouts._theme_css')
    @includeWhen(!empty($campaign), 'layouts._theme')
    @yield('styles')
</head>
<body id="app" class="{{ $pageClass ?? 'rich-page' }} @if (!empty($campaign) && auth()->check() && auth()->user()->can('admin', $campaign)) is-admin @endif" data-theme="{{ $specificTheme }}">

@yield('content')
<x-dialog id="primary-dialog" :loading="true" />
<div id="dialog-backdrop" class="z-1000 fixed top-0 left-0 right-0 bottom-0 h-full w-full backdrop-blur-sm hidden" style="--tw-bg-opacity: 0.2"></div>

<div class="toast-container fixed overflow-y-auto overflow-x-hidden bottom-4 right-4 max-h-full"></div>

@vite(['resources/js/vendor-final.js', 'resources/js/app.js'])
@includeWhen(config('fontawesome.kit'), 'layouts.scripts.fontawesome')

@yield('scripts')
@livewireScripts
@yield('modals')
@includeWhen(config('tracking.consent'), 'partials.cookieconsent')
</body>
</html>
