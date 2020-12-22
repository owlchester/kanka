@extends('layouts.front', [
    'title' => trans('front.menu.media'),
])

@section('og')
    <meta property="og:description" content="{{ __('front.media.description') }}" />
    <meta property="og:url" content="{{ route('front.media') }}" />
@endsection

@section('content')
    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-7 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ trans('front.media.title') }}</h1>
                        <p class="mb-5">{{ trans('front.media.description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="features" id="media">
        <div class="container">
            <div class="section-heading">
                <div class="row text-center">
                    <div class="col-6">
                        <h3>{{ __('front.media.images.primary') }}</h3>
                        <a href="https://kanka-app-assets.s3.amazonaws.com/images/logos/logo-large.png" target="_blank">
                            <img src="https://kanka-app-assets.s3.amazonaws.com/images/logos/logo-large.png" width="258" alt="kanka primary" />
                        </a>
                    </div>
                    <div class="col-6">
                        <h3>{{ __('front.media.images.social') }}</h3>
                        <a href="https://kanka-app-assets.s3.amazonaws.com/images/logos/icon-large.png" target="_blank">
                            <img src="https://kanka-app-assets.s3.amazonaws.com/images/logos/icon-large.png" width="258" alt="kanka social" />
                        </a>
                    </div>
            </div>
        </div>
    </section>
@endsection
