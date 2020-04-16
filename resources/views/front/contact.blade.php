@extends('layouts.front', [
    'title' => trans('front.menu.contact'),
    'active' => 'contact'
])
@section('content')

    <header class="masthead reduced-masthead" id="contact">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-7 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ trans('front.contact.title') }}</h1>
                        <p class="mb-5">{{ trans('front.contact.description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="features contact-us">
        <div class="container">
            <div class="section-body">
                <p>
                    {{ __('front.contact.email') }} <a href="mailto:hello@kanka.io">hello@kanka.io</a>
                </p>
                <p>
                    {{ __('front.contact.other') }}

                    <a href="{{ config('social.discord') }}" target="discord" title="Discord" rel="noreferrer">
                        <i class="fab fa-discord"></i>
                    </a>
                    <a href="{{ config('social.facebook') }}" target="facebook" title="Facebook" rel="noreferrer">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="{{ config('social.instagram') }}" target="instagram" title="Instagram" rel="noreferrer">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="{{ config('social.reddit') }}" target="reddit" title="Reddit" rel="noreferrer"><i class="fab fa-reddit"></i></a>
                </p>
            </div>
        </div>
    </section>
@endsection