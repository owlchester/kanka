@extends('layouts.front', [
    'title' => __('front/features/maps.title'),
    'active' => 'features',
])
@section('content')

    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-7 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ __('front/features/maps.title') }}</h1>
                        <p class="mb-5">{{ __('front/features/maps.description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="features" id="feature-map">
        <div class="containe text-center">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="container-fluid text-justify">
                        <p>{{ __('front/features/maps.first') }}</p>

                        <img src="/images/features/maps_setup.png" alt="Kanka map setup" class="m-2" style="max-width: 100%" />

                        <p>{{ __('front/features/maps.second') }}</p>
                        <p>{{ __('front/features/maps.third') }}</p>

                        <p class="text-center mb-5">
                            <a href="https://kanka.io/{{ app()->getLocale() }}/campaign/1/maps/8/explore" target="_blank" class="">
                                {{ __('front/features/maps.example') }}
                            </a>
                        </p>

                        <p>{!! __('front/features/maps.fourth', [
    'boosted_campaigns' => link_to_route('front.features', __('crud.boosted_campaigns'), '#boost')
]) !!}</p>

                        <img src="/images/features/maps.png" alt="Kanka map" class="m-2" style="max-width: 100%" />

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="features" id="next-feature">
        <div class="container text-center">

            <h1 class="mb-5">{{ __('front/features.other_features') }}</h1>

            <div class="row">
                <div class="col-lg-4">
                    @include('front.features._permissions')
                </div>
                <div class="col-lg-4">
                    @include('front.features._calendars')
                </div>
                <div class="col-lg-4">
                    @include('front.features._timelines')
                </div>
            </div>
        </div>
    </section>

@endsection
