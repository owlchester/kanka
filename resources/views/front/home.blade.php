@extends('layouts.front', [
    'metaDescription' => __('front.home.seo.meta-description'),
    'skipEnding' => true,
])
@section('content')
    @include('front.master')

    <section class="download bg-primary text-center" id="download">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <h2 class="section-heading">{{ trans('front.first_block.title') }}</h2>
                    <p>{{ trans('front.first_block.description') }}</p>
                </div>
            </div>
            <div class="device-container">
                <div class="device-mockup iphone6_plus portrait white">
                    <div class="device">
                        <div class="screen">
                            <img src="https://images.kanka.io/app/Waw_atyiOiNeph4a67qCzp_K6RA=/src/images%2Ffront%2Fdashboard.png{{ \App\Facades\Img::nowebp() ? '?webpfallback' : null }}" class="img-fluid" loading="lazy" width=819" height="461" alt="{{ config('app.name') }} tabletop rpg campaign management and worldbuilding dashboard">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="features" id="features">
        <div class="container">
            <div class="section-heading text-center">
                <h2>{{ trans('front.features.title') }}</h2>
                <p class="text-muted">{{ trans('front.features.description') }}</p>
                <hr>
            </div>
            <div class="row">
                <div class="col-lg-4 my-auto">
                    <div class="device-container">
                        <div class="device-mockup iphone6_plus portrait white">
                            <div class="device">
                                <div class="screen">
                                    <img src="https://images.kanka.io/app/BUB6ZG5CZdySIAR-8ou23TjXUbs=/src/images%2Ffront%2Fhome-image.png{{ \App\Facades\Img::nowebp() ? '?webpfallback' : null }}" loading="lazy" width="350" height="784" class="img-fluid" alt="{{ config('app.name') }} mobile tabletop rpg campaign management and worldbuilding dashboard">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 my-auto">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="feature-item">
                                    <i class="fas fa-layer-group text-primary"></i>
                                    <h3>{{ trans('front.features.layers.title') }}</h3>
                                    <p class="text-muted">{{ trans('front.features.layers.description') }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="feature-item">
                                    <i class="fas fa-calendar text-primary"></i>
                                    <h3>{{ trans('front.features.calendars.title') }}</h3>
                                    <p class="text-muted">{{ trans('front.features.calendars.description') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="feature-item">
                                    <i class="fas fa-gift text-primary"></i>
                                    <h3>{{ trans('front.features.free.title') }}</h3>
                                    <p class="text-muted">{!! trans('front.features.free.description', [
                                                'bonuses' => link_to(route('front.features', '#patreon'), __('front.features.free.bonuses')),
                                                'patreon' => 'Kanka'
                                            ]) !!}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="feature-item">
                                    <i class="fas fa-users text-primary"></i>
                                    <h3>{{ trans('front.features.collaborative.title') }}</h3>
                                    <p class="text-muted">{{ trans('front.features.collaborative.description') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <h4 class="mb-0">
                    <a href="{{ route('front.features') }}">{{ trans('front.features.learn_more') }}
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </h4>
            </div>
        </div>
    </section>

    <section id="pricing">
        <div class="container">
            <div class="section-heading text-center">
                <h2>{{ trans('front.pricing.title') }}</h2>
                <p class="text-muted">{{ trans('front.pricing.description') }}</p>
            </div>
            <div class="mb-3"><br /></div>
            <div class="mt-5">
            @include('front._pricing')
            </div>
        </div>
    </section>

    <section class="cta">
        <div class="cta-content">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-5 offset-md-7">
                        <h2>{!! trans('front.second_block.title') !!}</h2>@if(config('auth.register_enabled'))
                        <div class="text-center text-sm-left">
                            <a href="{{ route('register') }}" class="btn btn-outline btn-xl">
                                {{ trans('front.second_block.call_to_action') }}
                            </a>
                        </div>@endif
                    </div>
                </div>
            </div>
        </div>
        <div class="overlay"></div>
    </section>
@endsection
