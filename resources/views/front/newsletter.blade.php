@extends('layouts.front', [
    'title' => trans('front.menu.newsletter'),
])

@section('og')
    <meta property="og:description" content="{{ __('front/newsletter.description') }}" />
    <meta property="og:url" content="{{ route('front.newsletter') }}" />
@endsection

@section('content')

    <header class="masthead reduced-masthead" id="community">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-7 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ trans('front/newsletter.title') }}</h1>
                        <p class="mb-5">{{ trans('front/newsletter.headline') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="features" id="newsletter">
        <div class="container">
            <div class="section-body">
                @include('partials.newsletter', ['onlyForm' => true])
            </div>
        </div>
    </section>
@endsection
