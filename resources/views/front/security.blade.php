@extends('layouts.front', [
    'title' => __('footer.security'),
])

@section('og')
    <meta property="og:description" content="{{ __('front/security.description', ['kanka' => config('app.name')]) }}" />
    <meta property="og:url" content="{{ route('front.security') }}" />
@endsection

@section('content')
    <section class="features" id="security">
        <div class="container">
            <div class="section-heading">
                <div class="mb-5">
                    <h1 class="display-4">{{ __('front/security.title', ['kanka' => config('app.name')]) }}</h1>
                    <p class="lead">{{ __('front/security.description', ['kanka' => config('app.name')]) }}</p>
                </div>

                <h2>{{ __('front/security.data-center.title') }}</h2>
                <p class="my-2">
                    {!! __('front/security.data-center.description', ['kanka' => config('app.name')]) !!}
                </p>

                <h2 class="mt-5">{{ __('front/security.infrastructure.title') }}</h2>
                <p class="my-2">
                    {!! __('front/security.infrastructure.description', ['kanka' => config('app.name')]) !!}
                </p>

                <h2 class="mt-5">{{ __('front/security.communication.title') }}</h2>
                <p class="my-2">
                    {!! __('front/security.communication.description', ['kanka' => config('app.name')]) !!}
                </p>

                <h2 class="mt-5">{{ __('front/security.credit-card.title') }}</h2>
                <p class="my-2">
                    {!! __('front/security.credit-card.description', ['kanka' => config('app.name')]) !!}
                </p>

                <h2 class="mt-5">{{ __('front/security.data-backup.title') }}</h2>
                <p class="my-2">
                    {!! __('front/security.data-backup.description', ['kanka' => config('app.name')]) !!}
                </p>

                <h2 class="mt-5">{{ __('front/security.logs.title') }}</h2>
                <p class="my-2">
                    {!! __('front/security.logs.description', ['kanka' => config('app.name')]) !!}
                </p>

                <h2 class="mt-5">{{ __('front/security.data-breach.title') }}</h2>
                <p class="my-2">
                    {!! __('front/security.data-breach.description', ['kanka' => config('app.name')]) !!}
                </p>
            </div>
        </div>
    </section>
@endsection
