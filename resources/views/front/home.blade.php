@extends('layouts.front', [
    'metaDescription' => __('front.home.seo.meta-description')
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
                            <img src="/images/front/dashboard.png" class="img-fluid" loading="lazy" alt="{{ config('app.name') }} campaign management and worldbuilding dashboard">
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
                                    <img src="/images/front/home-image.png?v=2" loading="lazy" class="img-fluid" alt="{{ config('app.name') }} mobile campaign management and worldbuilding dashboard">
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
                                    <i class="icon-layers text-primary"></i>
                                    <h3>{{ trans('front.features.layers.title') }}</h3>
                                    <p class="text-muted">{{ trans('front.features.layers.description') }}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="feature-item">
                                    <i class="icon-notebook text-primary"></i>
                                    <h3>{{ trans('front.features.notebook.title') }}</h3>
                                    <p class="text-muted">{{ trans('front.features.notebook.description') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="feature-item">
                                    <i class="icon-present text-primary"></i>
                                    <h3>{{ trans('front.features.free.title') }}</h3>
                                    <p class="text-muted">{!! trans('front.features.free.description', [
                                                'bonuses' => link_to(route('front.features', '#patreon'), __('front.features.free.bonuses')),
                                                'patreon' => 'Kanka'
                                            ]) !!}</p>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="feature-item">
                                    <i class="icon-people text-primary"></i>
                                    <h3>{{ trans('front.features.collaborative.title') }}</h3>
                                    <p class="text-muted">{{ trans('front.features.collaborative.description') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-5">
                <h4>
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
                <h2>{!! trans('front.second_block.title') !!}</h2>
                        <div class="text-center text-sm-left">
                <a href="{{ route('register') }}" class="btn btn-outline btn-xl">
                    {{ trans('front.second_block.call_to_action') }}
                </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="overlay"></div>
    </section>
@endsection
