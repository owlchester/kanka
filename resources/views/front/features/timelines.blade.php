@extends('layouts.front', [
    'title' => __('front/features/timelines.title'),
    'active' => 'features',
])
@section('content')

    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-7 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ __('front/features/timelines.title') }}</h1>
                        <p class="mb-5">{{ __('front/features/timelines.description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="features" id="feature-timeline">
        <div class="containe text-center">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="container-fluid text-justify">
                        <p>{{ __('front/features/timelines.first') }}</p>

                        <img src="/images/features/timelines_standard.png" alt="Kanka timeline" class="m-2" style="max-width: 100%" />

                        <p>{{ __('front/features/timelines.second') }}</p>
                        <p>{{ __('front/features/timelines.third') }}</p>


                        <p>{!! __('front/features/timelines.fourth', [
    'boosted_campaigns' => link_to_route('front.pricing', __('crud.boosted_campaigns'), '#boost')
]) !!}</p>


                        <img src="/images/features/timelines_boosted.png" alt="Kanka timeline boosted" class="m-2" style="max-width: 100%" />

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="features" id="next-feature">
        <div class="container text-center">

            <h1 class="mb-5">{{ __('front/features.other_features') }}</h1>

            @include('front.features._buttons')

            <div class="row">
                <div class="col-lg-4">
                    @include('front.features._dashboards')
                </div>
                <div class="col-lg-4">
                    @include('front.features._calendars')
                </div>
                <div class="col-lg-4">
                    @include('front.features._secrets')
                </div>
            </div>
        </div>
    </section>

@endsection
