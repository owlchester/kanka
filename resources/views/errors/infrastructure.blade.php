<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ __('front.meta.description') }}">
    <meta name="author" content="{{ config('app.name') }}">
    <meta name="title" content="Infrastructure error">

    <meta property="og:title" content="Infrastructure error" />
    <meta property="og:site_name" content="{{ config('app.site_name') }}" />

    <title>Infrastructure error</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=5' name='viewport'>

    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
    <link rel="dns-prefetch" href="//kit.fontawesome.com">
    @vite('resources/css/front.css')
</head>
<body id="page-top">
    <section class="bg-purple text-white gap-16">
        <div class="px-6 py-20 lg:max-w-7xl mx-auto text-center flex flex-col gap-8">
                <h2>Infrastructure error</h2>
                <p class="lg:max-w-2xl mx-auto text-center">Kanka is currently unavailable due to an unplanned infrastructure outage.</p>
                <p class="lg:max-w-2xl mx-auto text-center">We have been notified and will fix the issue as soon as possible.</p>
                 <p class="lg:max-w-2xl mx-auto text-center">Join us over on our <a href="https://kanka.io/go/discord" class="link-light">Discord</a> to stay up to date with the issue.</p>
        </div>
    </section>

    @includeWhen(Route::has('home'), 'front.footer')
</body>
</html>
