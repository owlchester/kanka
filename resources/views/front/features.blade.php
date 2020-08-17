@extends('layouts.front', [
    'title' => __('front.menu.features'),
    'active' => 'features',
])
@section('content')

    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-7 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ __('front.features.title') }}</h1>
                        <p class="mb-5">{{ __('front.features.description_full') }}</p>
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
                                            <i class="fas fa-layer-group text-primary"></i>
                                            <h3>{{ __('front.features.layers.title') }}</h3>
                                            <p class="text-muted">{{ __('front.features.layers.description') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="feature-item">
                                            <i class="fas fa-book text-primary"></i>
                                            <h3>{{ __('front.features.notebook.title') }}</h3>
                                            <p class="text-muted">{{ __('front.features.notebook.description') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="feature-item">
                                            <i class="fas fa-gift text-primary"></i>
                                            <h3>{{ __('front.features.free.title') }}</h3>
                                            <p class="text-muted">{!! __('front.features.free.description', [
                                                'bonuses' => link_to('#patreon', __('front.features.free.bonuses')),
                                                'patreon' => 'Kanka',
                                            ]) !!}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="feature-item">
                                            <i class="fas fa-users text-primary"></i>
                                            <h3>{{ __('front.features.collaborative.title') }}</h3>
                                            <p class="text-muted">{{ __('front.features.collaborative.description') }}</p>
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
                                        <i class="fas fa-lock text-primary"></i>
                                        <h3>{{ __('front.features.public.title') }}</h3>
                                        <p class="text-muted">{!! __('front.features.public.description', ['url' => route('front.public_campaigns')]) !!}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="feature-item">
                                        <i class="fas fa-sync-alt text-primary"></i>
                                        <h3>{{ __('front.features.updates.title') }}</h3>
                                        <p class="text-muted">{!! __('front.features.updates.description', ['discord' => link_to(config('discord.url'), 'Discord', ['target' => '_blank'])]) !!}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="feature-item">
                                        <i class="fas fa-list text-primary"></i>
                                        <h3>{{ __('front.features.modular.title') }}</h3>
                                        <p class="text-muted">{{ __('front.features.modular.description') }}</p>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="feature-item">
                                        <i class="fa fa-map text-primary"></i>
                                        <h3>{{ __('front.features.maps.title') }}</h3>
                                        <p class="text-muted">{{ __('front.features.maps.description') }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="feature-item">
                                        <i class="fa fa-calendar text-primary"></i>
                                        <h3>{{ __('front.features.calendars.title') }}</h3>
                                        <p class="text-muted">{{ __('front.features.calendars.description') }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="feature-item">
                                        <i class="fa fa-compass text-primary"></i>
                                        <h3>{{ __('front.features.relations.title') }}</h3>
                                        <p class="text-muted">{{ __('front.features.relations.description') }}</p>
                                    </div>
                                </div>
                                <div class="col-lg-4 offset-lg-4">
                                    <div class="feature-item">
                                        <i class="fas fa-flask text-primary"></i>
                                        <h3>{{ __('front.features.api.title') }}</h3>
                                        <p class="text-muted">{!! __('front.features.api.description', ['link'
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
                    <h1 class="mb-5">{{ __('front.features.patreon.title') }}</h1>
                    <p class="mb-5">{{ __('front.features.patreon.description') }}</p>
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
                    <td>1 MB</td>
                    <td>8 MB</td>
                    <td>25 MB</td>
                </tr>
                <tr>
                    <td class="text">{{ __('front.features.patreon.upload_limit_map') }}</td>
                    <td>3 MB</td>
                    <td>10 MB</td>
                    <td>25 MB</td>
                </tr>
                <tr>
                    <td class="text">{{ __('front.features.patreon.users_roles') }}</td>
                    <td><i class="fa fa-infinity" title="{{ __('front.features.unlimited') }}"></i></td>
                    <td><i class="fa fa-infinity" title="{{ __('front.features.unlimited') }}"></i></td>
                    <td><i class="fa fa-infinity" title="{{ __('front.features.unlimited') }}"></i></td>
                </tr>
                <tr>
                    <td class="text">{{ __('front.features.patreon.entities') }}</td>
                    <td><i class="fa fa-infinity" title="{{ __('front.features.unlimited') }}"></i></td>
                    <td><i class="fa fa-infinity" title="{{ __('front.features.unlimited') }}"></i></td>
                    <td><i class="fa fa-infinity" title="{{ __('front.features.unlimited') }}"></i></td>
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
                    <td class="text">{{ __('front.features.patreon.pagination') }} <i class="fa fa-question-circle-o" title="{{ __('front.features.patreon.pagination_help') }}"></i></td>
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
                    <td>10</td>
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
                    <h1 class="mb-5">{{ __('front.features.boosts.title') }}</h1>
                    <p class="mb-5">{{ __('front.features.boosts.description') }}</p>
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
                    <td class="text">{{ __('front.features.boosts.entity_files') }}</td>
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
