@extends('layouts.front', [
    'title' => __('front.menu.pricing'),
    'active' => 'pricing'
])
@section('content')

    <header class="masthead reduced-masthead" id="pricing-head">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-7 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ __('front.pricing.title') }}</h1>
                        <p class="mb-5">{{ __('front.pricing.description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="features" id="pricing">
        <div class="container">
            <div class="section-body">
{{--                <h1>{{ __('front.pricing.index.title') }}</h1>--}}
{{--                <p class="text-muted">{{ __('front.index.description') }}</p>--}}

                @include('front._pricing')
            </div>
        </div>
    </section>

    @include('front._paid_features')
@endsection
