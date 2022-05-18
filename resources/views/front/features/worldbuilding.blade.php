@extends('layouts.front', [
    'title' => __('front/features.worldbuilding.title'),
    'active' => 'features',
])
@section('content')
    <section class="features" id="features-gm">
        <div class="container">
            <div class="mb-5">
                <h1 class="display-4">{{ __('front/features.worldbuilding.title', ['kanka' => config('app.name')]) }}</h1>
                <p class="lead">{{ __('front.features.description_full', ['kanka' => config('app.name')]) }}</p>
            </div>
            <div class="row text-center">
                <div class="col-lg-12">
                    <div class="container-fluid">
                        <div class="row">

                            <div class="col-md-4 col-6">
                                @include('front.features._timelines')
                            </div>
                            <div class="col-md-4 col-6">
                                @include('front.features._entities')
                            </div>

                            <div class="col-md-4 col-6">
                                @include('front.features._relations')
                            </div>

                            <div class="col-md-4 col-6">
                                @include('front.features._flora')
                            </div>
                            <div class="col-md-4 col-6">
                                @include('front.features._calendars')
                            </div>

                            <div class="col-md-4 col-6">
                                @include('front.features._api')
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center">
            <a href="{{ route('front.gm-features') }}" class="btn btn-primary btn-lg">
                {{ __('front.features.actions.rpg') }}
            </a>
            </div>
        </div>
    </section>

@endsection
