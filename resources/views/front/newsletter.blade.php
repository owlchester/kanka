@extends('layouts.front', [
    'title' => trans('front.menu.newsletter'),
])

@section('og')
    <meta property="og:description" content="{{ __('front/newsletter.description') }}" />
    <meta property="og:url" content="{{ route('front.newsletter') }}" />
@endsection

@section('content')

    <section class="features" id="newsletter">
        <div class="container">
            <div class="section-body">

                <div class="mb-5">
                    <h1 class="display-4">{{ __('front/newsletter.title') }}</h1>
                    <p class="lead">{{ __('front/newsletter.headline', ['kanka' => config('app.name')]) }}</p>
                </div>

                @include('partials.newsletter', ['onlyForm' => true])
            </div>
        </div>
    </section>
@endsection
