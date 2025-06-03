<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
@php AdCache::adless() @endphp
@include('layouts.tracking.tracking')

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ __('front.meta.description', ['kanka' => config('app.name')]) }}">
    <meta name="author" content="{{ config('app.name') }}">

    <meta property="og:title" content="{{ $title ?? __('front.meta.title', ['kanka' => config('app.name')]) }} - {{ config('app.name') }}" />
    <meta property="og:site_name" content="{{ config('app.site_name') }}" />

    <title>{{ $error }} {{ __('errors.' . $error . '.title') }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta content='width=device-width, initial-scale=1, maximum-scale=5' name='viewport'>
    @include('layouts.links.icons')
    @if (!config('fontawesome.kit'))<link href="/vendor/fontawesome/6.0.0/css/all.min.css" rel="stylesheet">@endif

    @if (config('app.asset_url'))
        <link rel="dns-prefetch" href="{{ config('app.asset_url') }}">
    @endif
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="//www.googletagmanager.com">

</head>

<body id="page-top">
@vite('resources/sass/front.scss')
<noscript id="deferred-styles">
</noscript>

@include('layouts.front.nav', ['minimal' => $error === 503])
<section class="bg-purple text-white gap-16" id="error-{{ $error }}">
    <div class="px-6 py-20 lg:max-w-7xl mx-auto text-center flex flex-col gap-8">
        @hasSection('content')
            @yield('content')
        @else
            <h2>{{ __('errors.' . $error . '.title') }}</h2>
            @if (is_array(__('errors.' . $error . '.body')))
                @foreach (__('errors.' . $error . '.body') as $text)
                    <p class="lg:max-w-2xl mx-auto text-center">{{ $text }}</p>
                @endforeach
            @else
                <p class="lg:max-w-2xl mx-auto text-center">{{ __('errors.' . $error . '.body') }}</p>
            @endif

            @guest
                <p class="lg:max-w-2xl mx-auto text-center">{{ __('errors.log-in') }}</p>
            @endguest
        @endif

        <p class="lg:max-w-2xl mx-auto text-center">
            {!! __('errors.footer', [
    'discord' => '<a href="' . config('social.discord') . '" class="link-light">Discord</a>',
    'email' => '<a href="mailto:' . config('app.email') . '" class="link-light">' . config('app.email') . '</a>',
]) !!}
        </p>
    </div>
</section>

<section class="lg:max-w-7xl mx-auto flex flex-col gap-10 lg:gap-10 py-10 lg:py-12 px-4 xl:px-0 text-dark text-center" >
    @if ($error !== 503 && auth()->check() && !\App\Facades\Identity::isImpersonating())
        <p class="text-md">{{ __('errors.back-to-campaigns') }}</p>
        <div class="flex flex-wrap justify-center items-center gap-10 max-w-3xl mx-auto">

        @foreach (auth()->user()->campaigns as $campaign)
            <a href="{{ route('dashboard', $campaign) }}" class="btn-round rounded flex gap-2 items-center">
                <x-icon class="fa-regular fa-arrow-right" />
                {!! $campaign->name !!}
            </a>
        @endforeach
        </div>
    @endif
</section>

@includeWhen(Route::has('home'), 'front.footer')
@vite('resources/js/front.js')
@if (config('fontawesome.kit'))
    <script src="https://kit.fontawesome.com/{{ config('fontawesome.kit') }}.js" crossorigin="anonymous"></script>
@endif

@includeWhen(config('tracking.consent'), 'partials.cookieconsent')
</body>
</html>
