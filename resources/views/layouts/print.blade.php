<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\Entity $entity
 */
$themeOverride = request()->get('_theme', 'base');
$specificTheme = null;
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
    @if (!config('fontawesome.kit'))<link href="/vendor/fontawesome/6.0.0/css/all.min.css" rel="stylesheet">@endif
    @yield('styles')
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
    @vite([
    'resources/css/print/print.css',
    ])
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto&display=swap">
</head>

<body class="{{ $entity->bodyClasses() }}  @if(isset($bodyClass)){{ $bodyClass }}@endif" @if(!empty($specificTheme)) data-theme="{{ $specificTheme }}" @endif>
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

    @if (config('fontawesome.kit'))
        <script src="https://kit.fontawesome.com/{{ config('fontawesome.kit') }}.js" crossorigin="anonymous"></script>
    @endif
    @vite(['resources/js/vendor-final.js', 'resources/js/app.js'])
    @yield('scripts')
</body>
</html>
