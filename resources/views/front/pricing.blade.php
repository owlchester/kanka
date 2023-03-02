@extends('layouts.front', [
    'title' => __('front.menu.pricing'),
    'active' => 'pricing',
    'skipPerf' => true,
])

@section('og')
    <meta property="og:description" content="{{ __('front.pricing.description', ['kanka' => config('app.name')]) }}" />
    <meta property="og:url" content="{{ route('front.pricing') }}" />
@endsection

@section('content')

    <section class="features" id="pricing">
        <div class="container">
            <div class="section-body">
                <div class="mb-5 text-center">
                    <h1 class="h6">{{ __('front.pricing.title') }}</h1>
                    <h2 class="h2 my-3">{!! __('front.pricing.lead.text', ['obvious' => '<strong>' . __('front.pricing.lead.obvious') . '</strong>']) !!}</h2>
                    <p class="lead">{{ __('front.pricing.refund') }}</p>
                </div>

                @include('front._pricing')

                <p class="mt-5 mb-1">{{ __('front/pricing.cards.description') }}
            </div>
        </div>
    </section>

    @include('front._paid_features')
    @include('front.pricing.faq')
@endsection
