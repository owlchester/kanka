@extends('layouts.front', [
    'title' => __('front/features/secrets.title'),
    'active' => 'features',
])
@section('content')

    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-7 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ __('front/features/secrets.title') }}</h1>
                        <p class="mb-5">{{ __('front/features/secrets.description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="features" id="feature-secret">
        <div class="containe text-center">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="container-fluid text-justify">
                        <p>{{ __('front/features/secrets.first') }}</p>

                        <div class="text-center">
                        <img src="/images/features/secrets.png" alt="Kanka secrets" class="mb-5" style="max-width: 100%" />
                        </div>

                        <p>{{ __('front/features/secrets.second') }}</p>
                        <p>{{ __('front/features/secrets.third') }}</p>

                        <p>{!! __('front/features/secrets.fourth') !!}</p>

                        <div class="text-center">
                        <img src="/images/features/secrets_pinned.png" alt="Kanka secrets pinned" class="mb-5" style="max-width: 100%" />
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
                    @include('front.features._permissions')
                </div>
                <div class="col-lg-4">
                    @include('front.features._maps')
                </div>
                <div class="col-lg-4">
                    @include('front.features._calendars')
                </div>
            </div>
        </div>
    </section>

@endsection
