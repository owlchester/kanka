<?php
/**
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\Entity $entity
 */
$themeOverride = request()->get('_theme');
$specificTheme = null;
$seoTitle = isset($seoTitle) ? $seoTitle : (isset($title) ? $title : null);
$showSidebar = (!empty($sidebar) && $sidebar === 'settings') || !empty($campaign);
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto&display=swap">
</head>
{{-- Hide the sidebar if the there is no current campaign --}}
<body class="@if(isset($entity)){{ $entity->bodyClasses() }}@endif @if(isset($bodyClass)){{ $bodyClass }}@endif @if (!empty($campaign) && auth()->check() && auth()->user()->isAdmin()) is-admin @endif @if(!app()->isProduction()) env-{{ app()->environment() }} @endif " @if(!empty($specificTheme)) data-theme="{{ $specificTheme }}" @endif @if (!empty($campaign)) data-user-member="{{ auth()->check() && auth()->user()->can('member', $campaign) ? 1 : 0 }}" @endif>

    <div id="app" class="wrapper ">
        <div class="content-wrapper">
            <section class="" role="main">
                @yield('content')
            </section>
        </div>
    </div>

    @yield('modals')


@if (config('fontawesome.kit'))
    <script src="https://kit.fontawesome.com/{{ config('fontawesome.kit') }}.js" crossorigin="anonymous"></script>
@endif
    @vite(['resources/js/vendor-final.js', 'resources/js/app.js'])
    @yield('scripts')
</body>
</html>
