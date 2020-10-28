@extends('layouts.front', [
    'metaDescription' => __('front.home.seo.meta-description'),
    'skipEnding' => true,
])
@section('content')
    @include('front.master')

    <section class="download bg-primary text-center" id="download">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <h2 class="section-heading">{{ __('front.first_block.title') }}</h2>
                    <p>{{ __('front.first_block.description') }}</p>
                </div>
            </div>
            <div class="device-container">
                <div class="device-mockup iphone6_plus portrait white">
                    <div class="device">
                        <div class="screen">
                            <img src="https://images.kanka.io/app/Waw_atyiOiNeph4a67qCzp_K6RA=/src/images%2Ffront%2Fdashboard.png{{ \App\Facades\Img::nowebp() ? '?webpfallback' : null }}" class="img-fluid" loading="lazy" width=819" height="461" alt="{{ config('app.name') }} tabletop rpg campaign management and worldbuilding dashboard">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="features" id="features">
        <div class="container">
            <div class="section-heading text-center">
                <h2>{{ __('front.features.title') }}</h2>
                <p class="text-muted">{{ __('front.features.description') }}</p>
                <hr>
            </div>
            @include('front.features.main')
        </div>
    </section>

    <section id="pricing">
        <div class="container">
            <div class="section-heading text-center">
                <h2>{{ __('front.pricing.title') }}</h2>
                <p class="text-muted">{{ __('front.pricing.description') }}</p>
            </div>
            <div class="mb-3"><br /></div>
            <div class="mt-5">
            @include('front._pricing')
            </div>
        </div>
    </section>
@endsection
