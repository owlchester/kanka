@extends('layouts.front', [
    'title' => trans('front.menu.help'),
    'menus' => [
        'help',
    ],
    'menu_js' => false,
])
@section('content')

    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-7 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ trans('front.help.title') }}</h1>
                        <p class="mb-5">{{ trans('front.help.description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="features" id="help">
        <div class="container">
            <div class="section-heading text-center">

                <div class="row">
                    <div class="col-lg-4">
                        <div class="feature-item">
                            <a href="{{ config('social.discord') }}">
                                <i class="fab fa-discord"></i>
                                <h3>{{ trans('front.help.discord') }}</h3>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="feature-item">
                            <a href="{{ config('social.facebook') }}">
                                <i class="fab fa-facebook"></i>
                                <h3>{{ trans('front.help.facebook') }}</h3>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="feature-item">
                            <a href="mailto:hello@kanka.io">
                                <i class="fa fa-envelope-open"></i>
                                <h3>{{ trans('front.help.email') }}</h3>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
