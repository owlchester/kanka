@extends('layouts.front', [
    'title' => __('front.menu.features'),
    'active' => 'features',
    'skipPerf' => true,
])
@section('og')
    <meta property="og:description" content="{{ __('front.features.description', ['kanka' => config('app.name')]) }}" />
    <meta property="og:url" content="{{ route('front.features') }}" />
@endsection

@section('content')

    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-9 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-3">{{ __('front.features.title') }}</h1>
                        <p class="mb-5">{{ __('front.features.description_full', ['kanka' => config('app.name')]) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="p-5" id="features">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-3 col-6">
                    <strong>{{ __('front/features.sections.general') }}</strong>
                    <ul class="m-0 p-0 list-unstyled">
                        <li class="py-1">
                            <a href="#free">{{ __('front.features.free.title') }}</a>
                        </li>
                        <li class="py-1">
                            <a href="#collaborative">{{ __('front.features.collaborative.title') }}</a>
                        </li>
                        <li class="py-1">
                            <a href="#dashboards">{{ __('front.features.dashboards.title') }}</a>
                        </li>
                        <li class="py-1">
                            <a href="#modular">{{ __('front.features.modular.title') }}</a>
                        </li>
                        <li class="py-1">
                            <a href="#updates">{{ __('front/features.updates.title') }}</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3 col-6">
                    <strong>{{ __('front/features.sections.rpg') }}</strong>
                    <ul class="list-unstyled m-0 p-0">
                        <li class="py-1">
                            <a href="#entity">{{ __('front/features.entity.title') }}</a>
                        </li>
                        <li class="py-1">
                            <a href="#inventory">{{ __('front/features.inventory.title') }}</a>
                        </li>
                        <li class="py-1">
                            <a href="#abilities">{{ __('front/features.abilities.title') }}</a>
                        </li>
                        <li class="py-1">
                            <a href="#attributes">{{ __('front/features.attributes.title') }}</a>
                        </li>
                        <li class="py-1">
                            <a href="#journals">{{ __('front/features.journals.title') }}</a>
                        </li>
                        <li class="py-1">
                            <a href="#quests">{{ __('front/features.quests.title') }}</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3 col-6">
                    <strong>{{ __('front/features.sections.worldbuilding') }}</strong>
                    <ul class="list-unstyled m-0 p-0">
                        <li class="py-1">
                            <a href="#relations">{{ __('front.features.relations.title') }}</a>
                        </li>
                        <li class="py-1">
                            <a href="#timelines">{{ __('front.features.timelines.title') }}</a>
                        </li>
                        <li class="py-1">
                            <a href="#calendars">{{ __('front.features.calendars.title') }}</a>
                        </li>
                        <li class="py-1">
                            <a href="#maps">{{ __('front.features.maps.title') }}</a>
                        </li>
                        <li class="py-1">
                            <a href="#editor">{{ __('front/features.editor.title') }}</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3 col-6">
                    <strong>{{ __('front/features.sections.premium') }}</strong>
                    <ul class="list-unstyled m-0 p-0">
                        <li class="py-1">
                            <a href="#premium">{{ __('footer.premium') }}</a>
                        </li>
                        <li class="py-1">
                            <a href="#marketplace">{{ __('front/features.marketplace.title') }}</a>
                        </li>
                        <li class="py-1">
                            <a href="#theming">{{ __('front/features.theming.title') }}</a>
                        </li>
                        <li class="py-1">
                            <a href="#links">{{ __('front/features.links.title') }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6" id="free">
                    <h3>{{ __('front.features.free.title') }}</h3>
                    <p class="text-muted">
                        {!! __('front/features.free.description', [
        'bonuses' => link_to_route('front.pricing', __('front.features.free.bonuses'), ['#paid-features']),
    ]) !!}
                    </p>
                </div>
                <div class="col-12 col-md-6" id="collaborative">
                    <h3>{{ __('front.features.collaborative.title') }}</h3>
                    <p class="text-muted">
                        {{ __('front/features.collaborative.description') }}
                    </p>
                </div>
            </div>
        </div>
    </section>


    <section class="p-5 bg-light" id="dashboards">
        <div class="container">
            <div class="row">
                <div class="col-12 col-xl-3">
                    <h3>{{ __('front/features.dashboards.title') }}</h3>
                    <p class="text-muted">
                        {!! __('front/features.dashboards.description') !!}
                    </p>
                    <a href="{{ route('front.features.dashboards') }}">
                        <i class="fa-solid fa-chevron-right"></i>
                        {{ __('front.features.learn_more_about') }}
                    </a>
                </div>
                <div class="col-12 col-xl-9">
                    <a href="https://kanka-app-assets.s3.amazonaws.com/images/features/dashboard-hd.jpg" target="_blank">
                        <img alt="Kanka dashboard" src="https://images.kanka.io/app/I953tDG_2cMATvI3dd4joD3hOqs=/825x464/smart/src/images%2Ffeatures%2Fdashboard-crop-hd.jpg" class="img-fluid shadow mb-2 rounded d-none d-lg-block" loading="lazy" >
                        <img alt="Kanka dashboard" src="https://images.kanka.io/app/zXQF2JO3vCediym8xg2ObAly3pc=/540x303/smart/src/images%2Ffeatures%2Fdashboard-crop-hd.jpg" class="d-lg-none img-fluid shadow mb-2 rounded" loading="lazy" >
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="p-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-12" id="modular">
                    <h3>{{ __('front.features.modular.title') }}</h3>
                    <p class="text-muted">
                        {{ __('front/features.modular.description') }}
                    </p>
                </div>
                <div class="col-md-6 col-12" id="updates">
                    <h3>{{ __('front/features.updates.title') }}</h3>
                    <p class="text-muted">
                        {!! __('front/features.updates.description', [
        'discord' => link_to(config('discord.url'), 'Discord', ['target' => '_blank', 'rel' => 'nofollow noreferrer']),
        'small-team' => link_to_route('front.about', __('front/features.updates.small-team'))

        ]) !!}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="p-5 bg-primary">
        <div class="container">
            <h2 class="text-center mb-5">
                {{ __('front/features.sections.rpg') }}
                <a href="#top"><i class="fa-solid fa-arrow-up"></i></a>
            </h2>

            <div class="row" id="entity">
                <div class="col-12 col-md-6">
                    <h3>{{ __('front/features.entity.title') }}</h3>
                    <p class="text-muted">
                        {{ __('front/features.entity.description') }}
                    </p>
                </div>
                <div class="col-12 col-md-6">
                    <a href="https://kanka-app-assets.s3.amazonaws.com/images/features/adam-morley-hd.jpg" target="_blank">
                        <img src="https://images.kanka.io/app/juM3syP-g6gENb83K_gjblCQeQI=/540x337/smart/src/images%2Ffeatures%2Fadam-morley-hd.jpg" alt="entity overview" class="img-fluid shadow mb-2 rounded" loading="lazy" />
                    </a>
                </div>
            </div>

            <div class="row mt-5" id="inventory">
                <div class="col-12 col-md-6">
                    <a href="https://kanka-app-assets.s3.amazonaws.com/images/features/sarah-inventory-hd.jpg" target="_blank">

                        <img src="https://images.kanka.io/app/we9Bjn5GNTuwyAs7sw_cC_0igfI=/540x225/smart/src/images%2Ffeatures%2Fsarah-inventory-hd.jpg" alt="entity inventory" class="img-fluid shadow mb-2" loading="lazy" />
                    </a>
                </div>
                <div class="col-12 col-md-6">
                    <h3>{{ __('front/features.inventory.title') }}</h3>
                    <p class="text-muted">
                        {{ __('front/features.inventory.description') }}
                    </p>
                </div>
            </div>
        </div>
    </section>


    <section class="p-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6" id="abilities">
                    <h3>{{ __('front/features.abilities.title') }}</h3>
                    <p class="text-muted">
                        {{ __('front/features.abilities.description') }}
                    </p>

                    <a href="https://kanka-app-assets.s3.amazonaws.com/images/features/ludwig-abilities-hd.jpg" target="_blank">
                        <img src="https://images.kanka.io/app/kKtGGaB6m5FxOz0qCDDvkjoTQ2o=/540x304/smart/src/images%2Ffeatures%2Fludwig-abilities-hd.jpg"
                             alt="entity abilities" class="img-fluid shadow mb-2 rounded" loading="lazy" />
                    </a>
                </div>

                <div class="col-12 col-md-6" id="attributes">
                    <h3>{{ __('front/features.attributes.title') }}</h3>
                    <p class="text-muted">
                        {{ __('front/features.attributes.description') }}
                    </p>
                    <p class="text-muted">
                        {!! __('front/features.attributes.secondary', ['marketplace' => link_to('https://marketplace.kanka.io/attribute-templates', __('front.menu.marketplace'), ['target' => '_blank'])]) !!}
                    </p>

                    <a href="https://kanka-app-assets.s3.amazonaws.com/images/features/attributes-holder-attributes-hd.jpg" target="_blank">
                        <img src="https://images.kanka.io/app/q9KWZf9InCLie65Tl5yHkofeG94=/540x350/smart/src/images%2Ffeatures%2Fattribute-holder-attributes-hd.jpg" alt="entity attributes" class="img-fluid shadow mb-2" loading="lazy" />
                    </a>

                </div>
            </div>
        </div>
    </section>

    <section class="p-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6" id="journals">
                    <h3>{{ __('front/features.journals.title') }}</h3>
                    <p class="text-muted">
                        {{ __('front/features.journals.description') }}
                    </p>
                    <img src="https://kanka-app-assets.s3.amazonaws.com/images/features/kanka-journals.jpg" alt="kanka journals" class="img-fluid shadow mb-2 rounded" loading="lazy" />
                </div>
                <div class="col-12 col-md-6" id="quests">
                    <h3>{{ __('front/features.quests.title') }}</h3>
                    <p class="text-muted">
                        {{ __('front/features.quests.description') }}
                    </p>
                    <img src="https://kanka-app-assets.s3.amazonaws.com/images/features/kanka-quest.jpg" alt="kanka quest" class="img-fluid shadow mb-2 rounded" loading="lazy" />
                </div>
            </div>
        </div>
    </section>


    <section class="p-5 bg-primary">
        <div class="container">
            <h2 class="text-center mb-5">
                {{ __('front/features.sections.worldbuilding') }}
                <a href="#top"><i class="fa-solid fa-arrow-up"></i></a>
            </h2>

            <div class="row" id="relations">
                <div class="col-12 col-lg-4 col-md-6">
                    <h3>{{ __('front.features.relations.title') }}</h3>
                    <p class="text-muted">
                        {{ __('front/features.relations.description') }}
                    </p>
                    <p class="text-muted">
                        {!! __('front/features.relations.secondary', [
    'boosted-campaigns' => link_to_route('front.pricing', __('footer.premium'), '#premium')
    ]
) !!}
                    </p>

                    <a href="{{ route('front.features.relations') }}">
                        <i class="fa-solid fa-chevron-right"></i>
                        {{ __('front.features.learn_more_about') }}
                    </a>
                </div>
                <div class="col-12 col-lg-8 col-md-6">
                    <div class="mb-2">
                            <img src="https://kanka-app-assets.s3.amazonaws.com/images/features/entity-relations-table.jpg" alt="entity relations table" class="img-fluid shadow rounded" loading="lazy" />
                        </div>
                        <div class="mb-2">
                            <img src="https://kanka-app-assets.s3.amazonaws.com/images/features/entity-relations-explorer.jpg" alt="entity relations explorer" class="img-fluid shadow rounded" loading="lazy" />
                        </div>
                    </div>
            </div>


            <div class="row mt-5" id="timelines">
                <div class="col-12 col-md-6">
                    <img src="/images/features/timelines_standard.png" alt="kanka timelines" class="img-fluid shadow mb-2 rounded" loading="lazy" />

                </div>
                <div class="col-12 col-md-6">
                    <h3>{{ __('front.features.timelines.title') }}</h3>
                    <p class="text-muted">
                        {{ __('front/features.timelines.description') }}
                    </p>

                    <a href="{{ route('front.features.timelines') }}">
                        <i class="fa-solid fa-chevron-right"></i>
                        {{ __('front.features.learn_more_about') }}
                    </a>


                </div>
            </div>
        </div>
    </section>

    <section class="p-5 bg-light">
        <div class="container">
            <div class="row" >
                <div class="col-12 col-md-6" id="calendars">
                    <h3>{{ __('front.features.calendars.title') }}</h3>
                    <p class="text-muted">
                        {{ __('front/features.calendars.description') }}
                    </p>
                    <a href="{{ route('front.features.calendars') }}">
                        <i class="fa-solid fa-chevron-right"></i>
                        {{ __('front.features.learn_more_about') }}
                    </a>
                    <img src="/images/features/calendars.png" alt="kanka calendar" class="img-fluid shadow mb-2 mt-2 rounded" loading="lazy" />

                </div>
                <div class="col-12 col-md-6" id="maps">
                    <h3>{{ __('front.features.maps.title') }}</h3>
                    <p class="text-muted">
                        {{ __('front/features.maps.description') }}
                    </p>
                    <a href="{{ route('front.features.maps') }}">
                        <i class="fa-solid fa-chevron-right"></i>
                        {{ __('front.features.learn_more_about') }}
                    </a>

                    <a href="https://kanka-app-assets.s3.amazonaws.com/images/features/map-hd.jpg" target="_blank">
                    <img src="https://images.kanka.io/app/yC8c-uQePHP0Qq4kE4jWevdHfMQ=/540x225/smart/src/images%2Ffeatures%2Fmap-hd.jpg" alt="kanka map" class="img-fluid shadow mb-2 mt-2 rounded" loading="lazy" />
                    </a>

                </div>
            </div>
        </div>
    </section>

    <section class="p-5 bg-primary">

        <div class="container">
            <div class="row" id="editor">
                <div class="col-12 col-lg-6">
                    <h3>{{ __('front/features.editor.title') }}</h3>
                    <p class="text-muted">
                        {!! __('front/features.editor.description', [
    'summernote' => link_to('https://summernote.org', 'Summernote', ['target' => '_blank', 'rel' => 'nofollow noreferrer']),
    'at-code' => '<code>@</code>',
]) !!}
                    </p>
                </div>
                <div class="col-12 col-lg-6 mb-2">
                    <img src="https://kanka-app-assets.s3.amazonaws.com/images/features/editor.jpg" alt="editor" class="img-fluid shadow rounded" loading="lazy" />
                </div>
            </div>
        </div>
    </section>

    <section class="p-5">
        <div class="container">
            <h2 class="text-center mb-5">
                {{ __('front/features.sections.premium') }}
                <a href="#top"><i class="fa-solid fa-arrow-up" aria-hidden="true"></i></a>
            </h2>

            <div class="row mb-5">
                <div class="col-12 col-md-6" id="premium">
                    <h3>{{ __('footer.premium') }}</h3>
                    <p class="text-muted">
                        {{ __('front/features.premium.description') }}
                    </p>
                    <a href="{{ route('front.premium') }}">
                        <i class="fa-solid fa-chevron-right"></i> {{ __('front/features.premium.link') }}
                    </a>
                </div>
                <div class="col-12 col-md-6" id="marketplace">
                    <h3>{{ __('front/features.marketplace.title') }}</h3>
                    <p class="text-muted">
                        {!! __('front/features.marketplace.description', ['marketplace' => link_to('https://marketplace.kanka.io', __('front.menu.marketplace'), ['target' => '_blank'])]) !!}
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-6" id="theming">
                    <h3>{{ __('front/features.theming.title') }}</h3>
                    <p class="text-muted">
                        {{ __('front/features.theming.description') }}
                    </p>
                </div>
                <div class="col-12 col-md-6" id="links">
                    <h3>{{ __('front/features.links.title') }}</h3>
                    <p class="text-muted">
                        {{ __('front/features.links.description') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    @if(config('auth.register_enabled'))
    <section class="p-5" id="call-to-action">
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
