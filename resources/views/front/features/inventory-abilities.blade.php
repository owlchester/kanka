@extends('layouts.front', [
    'title' => __('front/features/inventory-abilities.title'),
    'active' => 'features',
])
@section('content')

    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-7 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ __('front/features/inventory-abilities.title') }}</h1>
                        <p class="mb-5">{{ __('front/features/inventory-abilities.description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="features" id="feature-permission">
        <div class="containe text-center">
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="container-fluid text-justify">
                        <p>{{ __('front/features/inventory-abilities.first') }}</p>

                        <div class="text-center">
                        <img src="/images/features/inventory.png" alt="Kanka inventory" class="mb-5" style="max-width: 100%" />
                        </div>

                        <p>{{ __('front/features/inventory-abilities.second') }}</p>

                        <div class="text-center">
                        <img src="/images/features/abilities.png" alt="Kanka abilities" class="" style="max-width: 100%" />
                        </div>

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
                    @include('front.features._secrets')
                </div>
                <div class="col-lg-4">
                    @include('front.features._maps')
                </div>
                <div class="col-lg-4">
                    @include('front.features._timelines')
                </div>
            </div>
        </div>
    </section>

@endsection
