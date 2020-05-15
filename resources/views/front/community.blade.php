@extends('layouts.front', [
    'title' => trans('front.menu.community'),
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
                        <div class="card mb-5 mb-lg-0">
                            <div class="card-body">
                                <h5 class="card-title text-uppercase text-center"><i class="fab fa-discord fa-2x"></i> Discord</h5>
                                <p class="text-muted">{{ trans('front.community.discord') }}</p>
                                <a href="{{ config('social.discord') }}" class="btn btn-block btn-primary text-uppercase" rel="nofollow" >{{ trans('front.community.join') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card mb-5 mb-lg-0">
                            <div class="card-body">
                                <h5 class="card-title text-uppercase text-center"><i class="fab fa-instagram fa-2x"></i> Instagram</h5>
                                <p class="text-muted">{{ trans('front.community.instagram') }}</p>
                                <a href="{{ config('social.instagram') }}" class="btn btn-block btn-primary text-uppercase" rel="nofollow" >{{ trans('front.community.join') }}</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <br />
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="card mb-5 mb-lg-0">
                            <div class="card-body">
                                <h5 class="card-title text-uppercase text-center"><i class="fab fa-facebook fa-2x"></i> Facebook</h5>
                                <p class="text-muted">{{ trans('front.community.facebook') }}</p>
                                <a href="{{ config('social.facebook') }}" class="btn btn-block btn-primary text-uppercase" rel="nofollow" >{{ trans('front.community.join') }}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card mb-5 mb-lg-0">
                            <div class="card-body">
                                <h5 class="card-title text-uppercase text-center"><i class="fab fa-reddit fa-2x"></i> Reddit</h5>
                                <p class="text-muted">{{ trans('front.community.reddit') }}</p>
                                <a href="{{ config('social.reddit') }}" class="btn btn-block btn-primary text-uppercase" rel="nofollow" >{{ trans('front.community.join') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
