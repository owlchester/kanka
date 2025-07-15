<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    @php AdCache::adless() @endphp
    @include('layouts.tracking.tracking')

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ __('front.meta.description') }}">
    <meta name="author" content="{{ config('app.name') }}">

    <meta property="og:title" content="{{ $title ?? __('front.meta.title', ['kanka' => config('app.name')]) }}" />
    <meta property="og:site_name" content="{{ config('app.site_name') }}" />

    <title>{{ __('errors.503.title') }}</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=5' name='viewport'>
    @include('layouts.links.icons')

    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="//kit.fontawesome.com">
    <link rel="dns-prefetch" href="//www.googletagmanager.com">
    @vite('resources/sass/front.scss')
</head>

<body id="page-top">

@include('layouts.front.nav', ['minimal' => true])

<section class="bg-purple text-white gap-16">
    <div class="px-6 py-20 lg:max-w-7xl mx-auto text-center flex flex-col gap-8">
        @if (false)
        <h2 id="maintenance">Server maintenance</h2>

        <p class="lg:max-w-2xl mx-auto text-center">Kanka is currently unavailable due to planned server maintenance.</p>

        <p class="lg:max-w-2xl mx-auto text-center">This maintenance is planned to last until <a href="https://everytimezone.com/s/6d60e3d1" target="_blank" class="link-light"><x-icon class="link" />  15:30 UTC</a>.</p>
        @else

        <h2 id="maintenance">{{ __('errors.503.title') }}</h2>

        <p class="lg:max-w-2xl mx-auto text-center">{{ __('errors.503.body.1') }}</p>
        <p  class="lg:max-w-2xl mx-auto text-center">{{ __('errors.503.body.2') }}</p>
        @endif


        <p class="lg:max-w-2xl mx-auto text-center">Join us over on our <a href="https://kanka.io/go/discord" class="link-light">Discord</a> to be notified as soon as the maintenance is over.</p>
    </div>
</section>

<section class="max-w-2xl mx-auto flex flex-col gap-10 lg:gap-10 py-10 lg:py-12 px-4 xl:px-0 text-dark">
    <img src="/images/errors/maintenance.jpeg" alt="Maintenance" class="rounded-2xl" />
</section>

@yield('content')

@includeWhen(Route::has('home'), 'front.footer')
</body>
</html>
