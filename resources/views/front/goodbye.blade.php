@extends('layouts.front', [
    'metaDescription' => __('front.home.seo.meta-description'),
    'title' => __('front.meta.title', ['kanka' => config('app.name')]),
    'skipEnding' => true,
])


@section('og')
    <meta property="og:description" content="{{ __('front.home.seo.meta-description') }}" />
    <meta property="og:url" content="{{ route('home') }}" />
@endsection

@section('content')
    <section class="bg-primary text-justify" id="novel">
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <h2 class="section-heading">{{ __('front.goodbye.title') }}</h2>
                    <p>{{ __('front.goodbye.description_1') }}</p>
                    <p>{!! __('front.goodbye.description_2', ['email' => link_to('mailto:' . config('app.email'), config('app.email'))]) !!}</p>
                    <p>{{ __('front.goodbye.description_3') }}</p>
                    <p>{{ __('front.goodbye.description_4') }}</p>
                </div>
            </div>
        </div>
    </section>
@endsection
