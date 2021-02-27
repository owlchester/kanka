@extends('layouts.front', [
    'title' => __('front/features/calendars.title'),
    'active' => 'features',
])
@section('content')

    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-7 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ __('front/features/calendars.title') }}</h1>
                        <p class="mb-5">{{ __('front/features/calendars.description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="features" id="feature-calendar">
        <div class="containe text-center">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="container-fluid text-justify">
                        <p>{{ __('front/features/calendars.first') }}</p>

                        <p>{{ __('front/features/calendars.second') }}</p>

                        <div class="text-center">
                            <video width="640" height="291" controls>
                                <source src="/images/features/calendar_setup.mp4" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>

                        <p>{{ __('front/features/calendars.third') }}</p>

                        <p>{{ __('front/features/calendars.fourth') }}</p>


                        <div class="text-center">
                        <img src="/images/features/calendars.png" alt="Kanka calendar" class="mb-5" style="max-width: 100%" />
                        </div>

                        <p class="text-center mb-5">
                            <a href="https://kanka.io/{{ app()->getLocale() }}/campaign/6529/calendars/626" target="_blank" class="">
                                {{ __('front/features/maps.example') }}
                            </a>
                        </p>

                        <p>{{ __('front/features/calendars.fifth') }}</p>

                        <div class="text-center">
                        <img src="/images/features/calendar_widget.png" alt="Kanka calendar dashboard widget" width=class="mb-5" style="max-width: 100%" />
                        </div>

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
                    @include('front.features._timelines')
                </div>
                <div class="col-lg-4">
                    @include('front.features._maps')
                </div>
                <div class="col-lg-4">
                    @include('front.features._secrets')
                </div>
            </div>
        </div>
    </section>

@endsection
