@extends('layouts.front', [
    'title' => __('front/features.gm.title'),
    'active' => 'features',
])
@section('content')

    <section class="features" id="features-gm">
        <div class="container">
            <div class="mb-5">
                <h1 class="display-4">{{ __('front/features.gm.title', ['kanka' => config('app.name')]) }}</h1>
                <p class="lead">{{ __('front.features.description_full', ['kanka' => config('app.name')]) }}</p>
            </div>

            <div class="container-fluid text-center">
                <div class="row">
                    <div class="col-md-4 col-6">
                        @include('front.features._permissions')
                    </div>
                    <div class="col-md-4 col-6">
                        @include('front.features._calendars')
                    </div>
                    <div class="col-md-4 col-6">
                        @include('front.features._secrets')
                    </div>

                    <div class="col-md-4 col-6">
                        @include('front.features._entities')
                    </div>
                    <div class="col-md-4 col-6">
                        @include('front.features._quests')
                    </div>
                    <div class="col-md-4 col-6">
                        @include('front.features._abilities')
                    </div>

                    <div class="col-md-4 col-6 offset-md-2">
                        @include('front.features._audio')
                    </div>
                    <div class="col-md-4 col-6">
                        @include('front.features._api')
                    </div>
                </div>
            </div>
            <div class="text-center">
                <a href="{{ route('front.worldbuilder-features') }}" class="btn btn-primary btn-lg">
                    {{ __('front.features.actions.worldbuilder') }}
                </a>
            </div>
        </div>
    </section>

@endsection
