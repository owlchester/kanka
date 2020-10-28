@extends('layouts.front', [
    'title' => __('front.menu.features'),
    'active' => 'features',
])
@section('content')

    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-7 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ __('front.features.title') }}</h1>
                        <p class="mb-5">{{ __('front.features.description_full') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="features" id="help">
        <div class="container">
            @include('front.features.main')
        </div>
    </section>

    @include('front._paid_features')
@endsection
