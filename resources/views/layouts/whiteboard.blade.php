<?php /**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\Whiteboard $whiteboard
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
        'resources/css/app.css',
    ])
    @includeWhen(!config('fontawesome.kit'), 'layouts.styles.fontawesome')
    @if (!empty($themeOverride) && in_array($themeOverride, ['dark', 'midnight', 'base']))
        @php $specificTheme = $themeOverride; @endphp
        @if($themeOverride != 'base')
            @vite('resources/css/themes/' . request()->get('_theme') . '.css')
        @endif
    @else
        @if (!empty($campaign) && $campaign->boosted() && !empty($campaign->theme_id))
            @if ($campaign->theme_id !== 1)
                @vite('resources/css/themes/' . ($campaign->theme_id === 2 ? 'dark' : 'midnight') . '.css')
                @php $specificTheme = ($campaign->theme_id === 2 ? 'dark' : 'midnight') @endphp
            @endif
        @elseif (auth()->check() && !empty(auth()->user()->theme))
            @vite('resources/css/themes/' . auth()->user()->theme . '.css')
            @php $specificTheme = auth()->user()->theme @endphp
        @endif
    @endif
    @includeWhen(!empty($campaign), 'layouts._theme')
@yield('styles')
</head>
<body id="app" class="whiteboard-page @if (!empty($campaign) && auth()->check() && auth()->user()->isAdmin()) is-admin @endif" @if(!empty($specificTheme)) data-theme="{{ $specificTheme }}" @endif>

    @yield('content')
    <x-dialog id="primary-dialog" :loading="true" />
    <div id="dialog-backdrop" class="z-1000 fixed top-0 left-0 right-0 bottom-0 h-full w-full backdrop-blur-sm hidden" style="--tw-bg-opacity: 0.2"></div>

    <div class="toast-container fixed overflow-y-auto overflow-x-hidden bottom-4 right-4 max-h-full"></div>

@vite(['resources/js/vendor-final.js', 'resources/js/app.js', 'resources/js/whiteboards.js'])
    @includeWhen(config('fontawesome.kit'), 'layouts.scripts.fontawesome')

@yield('scripts')
@yield('modals')
@includeWhen(config('tracking.consent'), 'partials.cookieconsent')
</body>
</html>
