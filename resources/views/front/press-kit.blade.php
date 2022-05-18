@extends('layouts.front', [
    'title' => __('footer.press-kit'),
])

@section('og')
    <meta property="og:description" content="{{ __('front/press-kit.description', ['kanka' => config('app.name')]) }}" />
    <meta property="og:url" content="{{ route('front.press-kit') }}" />
@endsection

@section('content')
    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-9 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-3">{{ __('front/press-kit.title') }}</h1>
                        <p class="mb-5">{{ __('front/press-kit.description', ['kanka' => config('app.name')]) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="features" id="press-kit-ad-copy">
        <div class="container">
            <div class="section-heading">
                <h3>{{ __('front/press-kit.ad-copy.title') }}</h3>
                <p class="mb-3">
                    {!! __('front/press-kit.ad-copy.first', ['kanka' => link_to_route('home', config('app.name'), null, ['target' => '_blank'])]) !!}
                </p>
                <p>{{ __('front/press-kit.ad-copy.second', ['kanka' => config('app.name')]) }}</p>

                <h3 class="mt-5">{{ __('front/press-kit.logos') }}</h3>
                <p class="my-2">
                <a href="https://kanka-app-assets.s3.amazonaws.com/images/logos/kanka-logo-large.png" target="_blank">
                    <i class="fa-solid fa-image" aria-hidden="true"></i> kanka-logo-large.png
                </a> <small>25.7kb</small>
                </p>
                <p class="my-2">
                <a href="https://kanka-app-assets.s3.amazonaws.com/images/logos/kanka-icon-large.png" target="_blank">
                    <i class="fa-solid fa-image" aria-hidden="true"></i> kanka-icon-large.png
                </a> <small>14.0kb</small>
                </p>

                <p class="my-5">
                    {!! __('front/press-kit.more', ['email' => link_to('mailto:' . config('app.email'), config('app.email'))]) !!}
                </p>
            </div>
        </div>
    </section>
@endsection
