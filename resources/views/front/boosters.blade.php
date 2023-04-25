@extends('layouts.front', [
    'title' => __('footer.boosters'),
])

@section('og')
    <meta property="og:description" content="{{ __('front/boosters.description', ['kanka' => config('app.name')]) }}" />
    <meta property="og:url" content="{{ route('front.boosters') }}" />
@endsection

@section('content')
    <header class="masthead masthead-half @if (\App\Facades\DataLayer::groupB()) masthead-img @endif">
        <div class="container">
            <div class="row">
                <div class="col-12 my-5 landing-heading">
                    <h1 class="display-4 mt-5">{{ __('front/boosters.title') }}</h1>
                </div>
                <div class="col-12 col-md-7">
                    <div class="text-left mb-5 pb-5">
                        <p class="lead">{{ __('front/boosters.description', ['kanka' => config('app.name')]) }}</p>


                        @auth
                            <a href="{{ route('settings.subscription') }}" class="my-2 btn btn-primary btn-lg text-uppercase rounded px-3 py-2">
                                {!! __('front/boosters.starting', ['amount' => '5.<sup>00</sup>']) !!}
                            </a>
                        @else
                            <a href="{{ route('front.pricing') }}" class="my-2 btn btn-primary btn-lg text-uppercase rounded px-3">
                                {!! __('front/boosters.starting', ['amount' => '5.<sup>00</sup>']) !!}
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        <div class="overlay"></div>
    </header>

    <section class="py-50">
        <div class="container">
            <div class="alert alert-warning">
                <h4>Deprecated concept</h4>
                <p>Campaign boosters are a concept that have been replaced by the simpler <a class="btn btn-outline btn-primary" href="{{ route('front.premium') }}">Premium Campaigns</a></p>
            </div>
        </div>
    </section>

    <section class="py-50" id="boosted">
        <div class="container">
            <div class="section-heading text-center">

                <h2>{{ __('front/boosters.boost.title', ['kanka' => config('app.name')]) }}</h2>
                <p class="my-2">
                    {!! __('front/boosters.boost.description', ['kanka' => config('app.name')]) !!}
                </p>

                <div class="booster-cards my-5">
                    <div class="text-center booster-card">
                        <h5>{{ __('front/boosters.blocks.customise.title') }}</h5>
                        <p>
                            {!! __('front/boosters.blocks.customise.description', [
'marketplace' => link_to('https://marketplace.kanka.io', 'Marketplace', ['target' => '_blank'])
]) !!}
                        </p>
                        <img src="https://kanka-app-assets.s3.amazonaws.com/images/features/boosted/look-n-feel.jpg"
                             class="img-thumbnail" alt="{{ __('front/boosters.blocks.customise.title') }}" loading="lazy" />
                    </div>

                    <div class="text-center booster-card">
                        <h5>{{ __('front/boosters.blocks.entities.title') }}</h5>
                        <p>
                            {!! __('front/boosters.blocks.entities.description') !!}
                        </p>
                        <img src="https://kanka-app-assets.s3.amazonaws.com/images/features/boosted/entity.jpg"
                             class="img-thumbnail" alt="{{ __('front/boosters.blocks.entities.title') }}" loading="lazy" />
                    </div>

                    <div class="text-center booster-card">
                        <h5>{{ __('front/boosters.blocks.peace-of-mind.title') }}</h5>
                        <p>
                            {!! __('front/boosters.blocks.peace-of-mind.description', ['amount' => config('entities.hard_delete')]) !!}
                        </p>
                        <div class="img-thumbnail">
                            <i class="fa-solid fa-hourglass" aria-hidden="true"></i>
                        </div>
                    </div>

                    <div class="text-center booster-card">
                        <h5>{{ __('front/boosters.blocks.limits.title') }}</h5>
                        <p>
                            {!! __('front/boosters.blocks.limits.description') !!}
                        </p>
                        <div class="img-thumbnail">
                            <i class="fa-solid fa-infinity" aria-hidden="true"></i>
                        </div>
                    </div>

                    <div class="text-center booster-card">
                        <h5>{{ __('front/boosters.blocks.defaults.title') }}</h5>
                        <p>
                            {!! __('front/boosters.blocks.defaults.description') !!}
                        </p>
                        <img src="https://kanka-app-assets.s3.amazonaws.com/images/features/boosted/default.jpg"
                             class="img-thumbnail" alt="{{ __('front/boosters.blocks.defaults.title') }}" loading="lazy" />
                    </div>

                    <div class="text-center booster-card">
                        <h5>{{ __('front/boosters.blocks.gang.title') }}</h5>
                        <p>
                            {!! __('front/boosters.blocks.gang.description') !!}
                        </p>
                        <div class="img-thumbnail">
                            <i class="fa-solid fa-cloud-arrow-up" aria-hidden="true"></i>
                        </div>
                    </div>

                    <div class="text-center booster-card">
                        <h5>{{ __('front/boosters.blocks.icons.title') }}</h5>
                        <p>
                            {!! __('front/boosters.blocks.icons.description', [
    'fontawesome' => link_to(config('fontawesome.search'), 'FontAwesome', ['target' => '_blank']),
    'rpgawesome' => link_to('https://nagoshiashumari.github.io/Rpg-Awesome/', 'RPGAwesome', ['target' => '_blank'])
]) !!}
                        </p>
                        <img src="https://kanka-app-assets.s3.amazonaws.com/images/features/boosted/icon.jpg"
                             class="img-thumbnail" alt="{{ __('front/boosters.blocks.icons.title') }}" loading="lazy" />
                    </div>

                    <div class="text-center booster-card">
                        <h5>{{ __('front/boosters.blocks.relations.title') }}</h5>
                        <p>
                            {!! __('front/boosters.blocks.relations.description') !!}
                        </p>
                        <img src="https://kanka-app-assets.s3.amazonaws.com/images/features/boosted/boosted-relations.jpg"
                             class="img-thumbnail" alt="{{ __('front/boosters.blocks.relations.title') }}" loading="lazy" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-50" id="superboosted">
        <div class="container">
            <div class="section-heading text-center">
                <h2 class="">{{ __('front/boosters.superboost.title', ['kanka' => config('app.name')]) }}</h2>
                <p class="my-2">
                    {!! __('front/boosters.superboost.description', ['kanka' => config('app.name')]) !!}
                </p>

                <div class="booster-cards my-5">
                    <div class="text-center booster-card">
                        <h5>{{ __('front/boosters.superboosted.gallery.title') }}</h5>
                        <p>
                            {!! __('front/boosters.superboosted.gallery.description', []) !!}
                        </p>
                        <img src="https://kanka-app-assets.s3.amazonaws.com/images/features/boosted/gallery.jpg"
                             class="img-thumbnail" alt="{{ __('front/boosters.blocks.gallery.title') }}" loading="lazy" />
                    </div>
                    <div class="text-center booster-card">
                        <h5>{{ __('front/boosters.superboosted.achievements.title') }}</h5>
                        <p>
                            {!! __('front/boosters.superboosted.achievements.description', []) !!}
                        </p>
                        <img src="https://kanka-app-assets.s3.amazonaws.com/images/features/boosted/achievements.jpg"
                             class="img-thumbnail" alt="{{ __('front/boosters.superboosted.achievements.title') }}" loading="lazy" />
                    </div>
                    <div class="text-center booster-card">
                        <h5>{{ __('front/boosters.superboosted.logs.title') }}</h5>
                        <p>
                            {!! __('front/boosters.superboosted.logs.description', ['amount' => config('entities.hard_delete')]) !!}
                        </p>
                        <div class="img-thumbnail">
                            <i class="fa-solid fa-eye" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <section class="py-50" id="boosters-table">
        <div class="container">

            <h2>{{ __('front/boosters.table.title', ['kanka' => config('app.name')]) }}</h2>
            <p class="my-3">{{ __('front.features.boosts_v2.description') }} {!! __('front.features.boosts_v2.description-count', [
'boost-count' => '<strong>1</strong>', 'superboost-count' => '<strong>3</strong>',
]) !!} {{ __('front.features.boosts_v2.moving') }}
            </p>
            @include('front.features._booster_table')
        </div>
    </section>

    <section class="py-50">
        <div class="container text-center">
            <h2>{{__('front/boosters.call-to-action.title')}}</h2>
            <p class="my-3">
                {{ __('front/boosters.call-to-action.description') }}
            </p>

            @auth
                <a href="{{ route('settings.subscription') }}" class="my-2 btn btn-outline-primary text-uppercase">
                    <i class="fa-solid fa-arrow-alt-circle-right"></i> {{ __('front/boosters.call-to-action.go-to-sub') }}
                </a>
            @else
                <a href="{{ route('front.pricing') }}" class="my-2 btn btn-outline-primary text-uppercase">
                    <i class="fa-solid fa-arrow-alt-circle-right"></i> {{ __('front/boosters.call-to-action.go-to-pricing') }}
                </a>
            @endauth
        </div>
    </section>
@endsection
