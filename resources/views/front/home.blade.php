@extends('layouts.front', [
    'metaDescription' => __('front.home.seo.meta-description'),
    'title' => __('front.meta.title', ['kanka' => config('app.name')]),
    'skipEnding' => true,
])


@section('og')
    <meta property="og:description" content="{{ __('front.home.seo.meta-description') }}" />
    <meta property="og:url" content="{{ route('home') }}" />
@endsection

@section('content')
    @include('front.hero')

    <section class="bg-primary text-center" id="novel">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <h2 class="section-heading">{{ __('front.first_block.title') }}</h2>
                    <p>{{ __('front.first_block.description', ['kanka' => config('app.name')]) }}</p>
                </div>
            </div>
            <div class="device-container">
                <div class="device-mockup iphone6_plus portrait white">
                    <div class="device">
                        <img src="{{ Img::crop(900, 562)->new()->url('app/front/devices-preview-hd.png') }}" class="img-fluid d-none d-lg-inline-block" loading="lazy" alt="{{ config('app.name') }} tabletop rpg campaign management and worldbuilding dashboard">
                        <img src="{{ Img::crop(600, 375)->new()->url('app/front/devices-preview-hd.png') }}" class="img-fluid d-inline-block d-lg-none" loading="lazy" alt="{{ config('app.name') }} tabletop rpg campaign management and worldbuilding dashboard">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="features" id="features">
        <div class="container">
            <div class="section-heading text-center">
                <h2>{{ __('front.features.title') }}</h2>
                <p class="text-muted">{{ __('front.features.description', ['kanka' => config('app.name')]) }}</p>
            </div>


            <div class="">
                <div class="row mb-5">
                    <div class="col-12 col-xl-4">
                        <h3>{{ __('front/features.dashboards.title') }}</h3>
                        <p class="text-muted">
                            {!! __('front/features.dashboards.description', [
        'boosted-campaigns' => link_to_route('front.pricing', __('concept.premium-campaigns'), '#premium'),
    ]) !!}
                        </p>
                        <a href="{{ route('front.features.dashboards') }}">
                            <i class="fa-solid fa-chevron-right"></i>
                            {{ __('front.features.learn_more_about') }}
                        </a>
                    </div>
                    <div class="col-12 col-xl-8">
                        <a href="https://kanka-users-assets.s3.amazonaws.com/app/features/dashboard-hd.jpg" target="_blank">
                            <img alt="Kanka dashboard" src="{{ Img::crop(825, 464)->new()->url('app/features/dashboard-crop-hd.jpg') }}" class="img-fluid shadow mb-2 rounded d-none d-lg-block" loading="lazy" >
                            <img alt="Kanka dashboard" src="{{ Img::crop(540, 303)->new()->url('app/features/dashboard-crop-hd.jpg') }}" class="d-lg-none img-fluid shadow mb-2 rounded" loading="lazy" >
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6" id="collaborative">
                        <h3>{{ __('front.features.collaborative.title') }}</h3>
                        <p class="text-muted">
                            {{ __('front/features.collaborative.description') }}
                        </p>
                    </div>
                    <div class="col-md-6 col-12" id="modular">
                        <h3>{{ __('front.features.modular.title') }}</h3>
                        <p class="text-muted">
                            {{ __('front/features.modular.description') }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="m-3 text-center">
            <a href="{{ route('front.features') }}" class="btn btn-primary btn-lg">
                {{ __('front/features.discover-all') }}
            </a>
            </div>
        </div>
    </section>

    @if (config('services.stripe.enabled'))
    <section id="pricing" class="pt-2">
        <div class="container">
            <div class="section-heading text-center">
                <h2>{{ __('front.pricing.title') }}</h2>
                <p class="text-muted my-3">{!! __('front.pricing.lead.text', ['obvious' => '<strong>' . __('front.pricing.lead.obvious') . '</strong>']) !!}<br />{{ __('front.pricing.refund') }}</p>
            </div>
            @include('front._pricing')
        </div>
    </section>
    @endif

    @includeWhen(false, 'front._testimonials')

    @includeWhen(!empty($campaigns), 'front._campaigns')

    @if(config('auth.register_enabled'))
        <section class="p-0 mb-5" id="call-to-action">
            <div class="container">
                <div class="text-center">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg mr-sm-3 mr-md-5 mb-3 mb-sm-0 d-block d-sm-inline-block">
                        {{ __('front/features.register') }}
                    </a>
                </div>
            </div>
        </section>
    @endif
@endsection
