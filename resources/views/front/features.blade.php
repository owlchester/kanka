@extends('layouts.front', [
    'title' => trans('front.menu.features'),
    'active' => 'features',
])
@section('content')

    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-7 my-auto">
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
            <div class="text-center">
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
                                            <p class="text-muted">{!! trans('front.features.free.description', [
                                                'bonuses' => link_to('#patreon', __('front.features.free.bonuses')),
                                                'patreon' => 'Kanka',
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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="feature-item">
                                        <i class="icon-lock text-primary"></i>
                                        <h3>{{ trans('front.features.public.title') }}</h3>
                                        <p class="text-muted">{!! trans('front.features.public.description', ['url' => route('front.public_campaigns')]) !!}</p>
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
                                <div class="col-lg-4 offset-lg-4">
                                    <div class="feature-item">
                                        <i class="icon-chemistry text-primary"></i>
                                        <h3>{{ trans('front.features.api.title') }}</h3>
                                        <p class="text-muted">{!! trans('front.features.api.description', ['link'
                                            => link_to('/docs/1.0', __('front.features.api.link'))
                                        ]) !!}</p>
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

    <section class="minimal-padding" id="patreon">
        <div class="container">
            <div class="col-lg-12 my-auto">
                <div class="header-content mx-auto">
                    <h1 class="mb-5">{{ trans('front.features.patreon.title') }}</h1>
                    <p class="mb-5">{{ trans('front.features.patreon.description') }}</p>
                </div>
            </div>

            <table class="table">
                <thead>
                <tr>
                    <th></th>
                    <th>{{ __('front.features.patreon.free') }}</th>
                    <th>{{ __('patreon.pledges.owlbear') }}</th>
                    <th>{{ __('patreon.pledges.elemental') }}</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="text">{{ __('front.features.patreon.upload_limit') }}</td>
                    <td>1mb </td>
                    <td>8mb</td>
                    <td>25mb</td>
                </tr>
                <tr>
                    <td class="text">{{ __('front.features.patreon.upload_limit_map') }}</td>
                    <td>1mb </td>
                    <td>10mb</td>
                    <td>25mb</td>
                </tr>
                <tr>
                    <td class="text">{{ __('front.features.patreon.discord') }}</td>
                    <td></td>
                    <td><i class="fa fa-check-circle"></i></td>
                    <td><i class="fa fa-check-circle"></i></td>
                </tr>
                <tr>
                    <td class="text">{{ __('front.features.patreon.default_image') }}</td>
                    <td></td>
                    <td><i class="fa fa-check-circle"></i></td>
                    <td><i class="fa fa-check-circle"></i></td>
                </tr>
                <tr>
                    <td class="text">{!! __('front.features.patreon.hall_of_fame', ['link' => link_to_route('front.about', __('teams.hall_of_fame'), ['#patreon'])]) !!}</td>
                    <td></td>
                    <td><i class="fa fa-check-circle"></i></td>
                    <td><i class="fa fa-check-circle"></i></td>
                </tr>
                <tr>
                    <td class="text">{{ __('front.features.patreon.api_calls') }}</td>
                    <td></td>
                    <td><i class="fa fa-check-circle"></i></td>
                    <td><i class="fa fa-check-circle"></i></td>
                </tr>
                <tr>
                    <td class="text">{{ __('front.features.patreon.pagination') }}</td>
                    <td></td>
                    <td><i class="fa fa-check-circle"></i></td>
                    <td><i class="fa fa-check-circle"></i></td>
                </tr>
                <tr>
                    <td class="text">{{ __('front.features.patreon.monthly_vote') }}</td>
                    <td></td>
                    <td><i class="fa fa-check-circle"></i></td>
                    <td><i class="fa fa-check-circle"></i></td>
                </tr>
                <tr>
                    <td class="text">{{ __('front.features.patreon.boosts') }}</td>
                    <td></td>
                    <td>3</td>
                    <td>5</td>
                </tr>
                <tr>
                    <td class="text">{{ __('front.features.patreon.curation') }}</td>
                    <td></td>
                    <td></td>
                    <td><i class="fa fa-check-circle"></i></td>
                </tr>
                <tr>
                    <td class="text">{{ __('front.features.patreon.impact') }}</td>
                    <td></td>
                    <td></td>
                    <td><i class="fa fa-check-circle"></i></td>
                </tr>
                </tbody>
            </table>

        </div>
    </section>

    <section class="minimal-padding" id="boost">
        <div class="container">
            <div class="col-lg-12 my-auto">
                <div class="header-content mx-auto">
                    <h1 class="mb-5">{{ trans('front.features.boosts.title') }}</h1>
                    <p class="mb-5">{{ trans('front.features.boosts.description') }}</p>
                </div>
            </div>

            <table class="table">
                <thead>
                <tr>
                    <th></th>
                    <th>{{ __('front.features.boosts.boosted') }}</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="text">{{ __('front.features.boosts.theme') }}</td>
                    <td><i class="fa fa-check-circle"></i></td>
                </tr>
                <tr>
                    <td class="text">{{ __('front.features.boosts.css') }}</td>
                    <td><i class="fa fa-check-circle"></i></td>
                </tr>
                <tr>
                    <td class="text">{{ __('front.features.boosts.tooltip') }}</td>
                    <td><i class="fa fa-check-circle"></i></td>
                </tr>
                <tr>
                    <td class="text">{{ __('front.features.boosts.header_image') }}</td>
                    <td><i class="fa fa-check-circle"></i></td>
                </tr>
                <tr>
                    <td class="text">{{ __('front.features.boosts.images') }}</td>
                    <td><i class="fa fa-check-circle"></i></td>
                </tr>
                <tr>
                    <td class="text">{{ __('front.features.boosts.upload') }}</td>
                    <td><i class="fa fa-check-circle"></i></td>
                </tr>
                <tr>
                    <td class="text">{{ __('front.features.boosts.recovery') }}</td>
                    <td><i class="fa fa-check-circle"></i></td>
                </tr>
                <tr>
                    <td class="text">{{ __('front.features.boosts.beta') }}</td>
                    <td><i class="fa fa-check-circle"></i></td>
                </tr>
                </tbody>
            </table>


            <div class="col-lg-6 my-auto">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="" data-src="https://www.youtube.com/embed/eSyHGSq4SbE" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </section>
@endsection
