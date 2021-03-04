@extends('layouts.front', [
    'title' => __('front/features/permissions.title'),
    'active' => 'features',
])
@section('content')

    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-7 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ __('front/features/permissions.title') }}</h1>
                        <p class="mb-5">{{ __('front/features/permissions.description') }}</p>
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
                        <p>{{ __('front/features/permissions.first') }}</p>

                        <div class="text-center">
                        <img src="/images/features/permissions_role.png" alt="Kanka permission role" class="mb-5" style="max-width: 100%" />
                        </div>

                        <p>{{ __('front/features/permissions.second') }}</p>
                        <p>{{ __('front/features/permissions.third') }}</p>

                        <div class="text-center">
                        <img src="/images/features/permissions_entity.png" alt="Kanka permission entity" class="mb-5" style="max-width: 100%" />
                        </div>

                        <p>{{ __('front/features/permissions.fourth') }}</p>

                        <div class="text-center">
                        <img src="/images/features/permissions_view_as.png" alt="Kanka permission view as" class="mb-5" style="max-width: 100%" />
                        </div>

                        <p>{{ __('front/features/permissions.fifth') }}</p>


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
