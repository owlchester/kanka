@extends('layouts.front', [
    'title' => trans('front.menu.features'),
    'menus' => [
        'features',
    ],
    'menu_js' => false,
])
@section('content')

    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-12 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ trans('front.features.title') }}</h1>
                        <p class="mb-5">{{ trans('front.features.description_full') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="features" id="help">
        <div class="container">
            <div class="section-heading text-center">
                <div class="row">
                    <div class="col-lg-4 my-auto">
                        <div class="device-container">
                            <div class="device-mockup iphone6_plus portrait white">
                                <div class="device">
                                    <div class="screen">
                                        <!-- Demo image for screen mockup, you can put an image here, some HTML, an animation, video, or anything else! -->
                                        <img src="/images/front/home-image.png" class="img-fluid" alt="{{ config('app.name') }} dashboard">
                                    </div>
                                    <div class="button">
                                        <!-- You can hook the "home button" to some JavaScript events or just remove it -->
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
                                            <p class="text-muted">{{ trans('front.features.free.description') }}</p>
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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="feature-item">
                                        <i class="icon-lock text-primary"></i>
                                        <h3>{{ trans('front.features.public.title') }}</h3>
                                        <p class="text-muted">{!! trans('front.features.public.description', ['link' => route('public_campaigns')]) !!}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="feature-item">
                                        <i class="icon-arrow-up-circle text-primary"></i>
                                        <h3>{{ trans('front.features.updates.title') }}</h3>
                                        <p class="text-muted">{{ trans('front.features.updates.description') }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="feature-item">
                                        <i class="icon-list text-primary"></i>
                                        <h3>{{ trans('front.features.modular.title') }}</h3>
                                        <p class="text-muted">{{ trans('front.features.modular.description') }}</p>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="feature-item">
                                        <i class="icon-map text-primary"></i>
                                        <h3>{{ trans('front.features.maps.title') }}</h3>
                                        <p class="text-muted">{{ trans('front.features.maps.description') }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="feature-item">
                                        <i class="icon-calendar text-primary"></i>
                                        <h3>{{ trans('front.features.calendars.title') }}</h3>
                                        <p class="text-muted">{{ trans('front.features.calendars.description') }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="feature-item">
                                        <i class="icon-compass text-primary"></i>
                                        <h3>{{ trans('front.features.relations.title') }}</h3>
                                        <p class="text-muted">{{ trans('front.features.relations.description') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="container-fluid">
                            <div class="row">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection