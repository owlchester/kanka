@extends('layouts.front', [
    'title' => __('front/features.worldbuilding.title'),
    'active' => 'features',
])
@section('content')

    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-7 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ __('front/features.worldbuilding.title') }}</h1>
                        <p class="mb-5">{{ __('front.features.description_full') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="features" id="features-gm">
        <div class="containe text-center">
            <div class="row">
                <div class="col-lg-12">
                    <div class="container-fluid">
                        <div class="row">

                            <div class="col-lg-4">
                                @include('front.features._timelines')
                            </div>
                            <div class="col-lg-4">
                                @include('front.features._entities')
                            </div>
                            <div class="col-lg-4">
                                @include('front.features._collaborative')
                            </div>

                            <div class="col-lg-4">
                                @include('front.features._relations')
                            </div>
                            <div class="col-lg-4">
                                @include('front.features._flora')
                            </div>
                            <div class="col-lg-4">
                                @include('front.features._calendars')
                            </div>

                            <div class="col-lg-4 offset-lg-4">
                                @include('front.features._api')

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pricing">
            <a href="{{ route('front.gm-features') }}" class="btn btn-primary btn-lg">
                {{ __('front.features.actions.rpg') }}
            </a>
            </div>
        </div>
    </section>

@endsection
