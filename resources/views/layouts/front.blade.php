@php

$cleanCanonical = \Illuminate\Support\Str::before(request()->fullUrl(), '%3');
@endphp
<html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content='width=device-width, initial-scale=1, maximum-scale=5, shrink-to-fit=no'>
    <meta name="author" content="{{ config('app.name') }}">
    <meta name="description" content="{{ $metaDescription ?? __('front.home.seo.meta-description', ['kanka' =>  config('app.name')]) }}">
    <meta name="keywords" content="{{  $metaKeywords ?? __('front.seo.keywords') }}">

    <meta property="og:title" content="{{ $title ?? __('front.meta.title', ['kanka' =>  config('app.name')]) }}@if (!isset($skipEnding)) - {{ config('app.name') }} @endif">
    <meta property="og:site_name" content="{{ config('app.site_name') }}">
    <meta property="og:type" content="website" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:image" content="https://d3a4xjr8r2ldhu.cloudfront.net/app/front/preview-background.png" />
    <meta name="twitter:image:alt" content="{{ config('app.name') }} showcase of a character view" />
@if(config('services.facebook.client_id'))  <meta property="fb:app_id" content="{{ config('services.facebook.client_id') }}" />@endif

    @yield('og')
@if(config('app.admin'))
    @if (!isset($ogImage) || !$ogImage)
    <meta property="og:image" content="https://d3a4xjr8r2ldhu.cloudfront.net/app/front/preview-background.png" />
    <meta property="og:image:type" content="image/png" />
    <meta property="og:image:width" content="1920" />
    <meta property="og:image:height" content="1024" />
    <meta property="og:image:alt" content="{{ config('app.name') }} showcase of a character view" />
    @endif
    <script type="application/ld+json">
      {
        "@id": "#product",
        "@type": "WebApplication",
        "@context": "http://schema.org/",
        "name": "{{ config('app.name') }}",
        "description": "{{ $metaDescription ?? __('front.home.seo.meta-description') }}",
        "url": "{{ config('app.url') }}",
        "applicationCategory": "Game, Note taking",
        "operatingSystem": "all",
        "image": ["https://th.kanka.io/o-ZrT3jpQVW_Nd_1g5eBAGg7wpU=/1920x1024/smart/src/app/front/preview-background.png"],
        "screenshot": "https://th.kanka.io/T35QId2XP7bbGxy0c237Qr9woSs=/600x320/smart/src/app/front/preview-background.png",
        "creator": {
          "@type": "Organization",
          "@id": "#organization",
          "url": "{{ config('app.url') }}",
          "name": "{{ config('app.name') }}",
          "logo": { "@type": "ImageObject", "url": "https://th.kanka.io/z4Y8iu74nWLlIPFWld-QY5jHQWM=/226x205/smart/src/app/logos/kanka-logo-large.png", "width": "226", "height": "205" }
        }
      }
    </script>@endif

    <title>{{ $title ?? __('front.meta.title', ['kanka' => config('app.name')]) }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @include('layouts.links.icons')

    <link rel="canonical" href="{{ $cleanCanonical }}" />

    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="//kit.fontawesome.com">
    <link rel="dns-prefetch" href="//www.googletagmanager.com">

    @vite('resources/css/front.css')
    @livewireStyles
    @yield('styles')
    @include('layouts.tracking.tracking', ['frontLayout' => true])
</head>

<body id="page-top" class="">
<noscript id="deferred-styles">
</noscript>

<div id="top"></div>
@include('layouts.front.nav')

    @yield('content')
@include('front.footer')

@vite(['resources/js/front.js'])
@includeWhen(config('fontawesome.kit'), 'layouts.scripts.fontawesome')
@includeWhen(config('tracking.consent'), 'partials.cookieconsent')
<div id="dialog-backdrop" class="z-1000 fixed top-0 left-0 right-0 bottom-0 h-full w-full backdrop-blur-sm hidden" style="--tw-bg-opacity: 0.2"></div>
@yield('modals')
@yield('scripts')
@livewireScripts
</body>
</html>
