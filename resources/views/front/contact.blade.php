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
            </div>
        </div>
    </section>
@endsection
