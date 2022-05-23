@extends('layouts.front', [
    'title' => __('front.menu.contact'),
    'active' => 'contact'
])
@section('content')

    <section class="features contact-us">
        <div class="container">
            <div class="section-body">
                <div class="mb-5">
                    <h1 class="display-4">{{ __('front.contact.title') }}</h1>
                    <p class="lead">{{ __('front.contact.description', ['kanka' => config('app.name')]) }}</p>
                </div>

                <p class="my-3">
                    {{ __('front.contact.email') }} <a href="mailto:{{ config('app.email') }}">{{ config('app.email') }}</a>
                </p>
                <p class="my-3">
                    {{ __('front.contact.other') }}

                    <a href="{{ config('social.discord') }}" class="mr-2" target="discord" title="Discord" rel="noreferrer">
                        <i class="fab fa-discord"></i>
                    </a>
                    <a href="{{ config('social.facebook') }}" class="mr-2" target="facebook" title="Facebook" rel="noreferrer">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="{{ config('social.instagram') }}" class="mr-2" target="instagram" title="Instagram" rel="noreferrer">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="{{ config('social.reddit') }}" target="reddit" title="Reddit" rel="noreferrer"><i class="fab fa-reddit"></i></a>
                </p>
            </div>
        </div>
    </section>
@endsection
