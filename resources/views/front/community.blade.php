@extends('layouts.front', [
    'title' => trans('front.menu.community'),
    'menus' => [
        'community',
    ],
    'menu_js' => false,
])
@section('content')

    <header class="masthead reduced-masthead" id="community">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-7 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ trans('front.community.title') }}</h1>
                        <p class="mb-5">{{ trans('front.community.description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="features" id="communities">
        <div class="container">
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="feature-item">
                            <i class="fab fa-discord"></i>
                            <h3>Discord</h3>
                            <p class="text-muted">{{ trans('front.community.discord') }}</p>
                            <p class="text-muted"><a href="https://discord.gg/rhsyZJ4">{{ trans('front.community.join') }}</a></p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="feature-item">
                            <i class="fab fa-reddit"></i>
                            <h3>Reddit</h3>
                            <p class="text-muted">{{ trans('front.community.reddit') }}</p>
                            <p class="text-muted"><a href="https://reddit.com/r/kanka">{{ trans('front.community.join') }}</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection