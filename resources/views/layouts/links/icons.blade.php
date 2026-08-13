@if (config('filesystems.disks.assets.url'))
<link rel="icon" type="image/svg+xml" href="{{ asset('/images/favicon/favicon.svg') }}" />
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('/images/favicon/favicon-32x32.png') }}">
<link rel="apple-touch-icon" href="{{ asset('/images/favicon/apple-touch-icon.png') }}" />
<link rel="manifest" href="{{ asset('/images/favicon/site.webmanifest') }}" />
@endif

<meta name="apple-mobile-web-app-title" content="{{ $campaign->name ?? config('app.name') }}">
<meta name="apple-mobile-web-app-status-bar-style" content="#40479e">
