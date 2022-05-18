@extends('layouts.front', [
    'title' => __('front.menu.pricing'),
    'active' => 'pricing',
    'skipPerf' => true,
])
@section('content')

    <section class="features" id="pricing">
        <div class="container">
            <div class="section-body">
                <div class="mb-5">
                    <h1 class="display-4">{{ __('front.pricing.title') }}</h1>
                    <p class="lead">{{ __('front.pricing.description', ['kanka' => config('app.name')]) }}</p>
                </div>

                @include('front._pricing')
            </div>
        </div>
    </section>

    @include('front._paid_features')
@endsection
