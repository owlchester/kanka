@extends('layouts.front', [
    'title' => trans('front.menu.roadmap'),
])
@section('content')

    <header class="masthead reduced-masthead" id="roadmap">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-7 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ trans('front.roadmap.title') }}</h1>
                        <p class="mb-5">{{ trans('front.roadmap.description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="features" id="roadmaps">
        <div class="container">
            <div class="section-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="feature-item">
                            <i class="fab fa-list"></i>
                            <h3><a href="https://trello.com/b/62aOwCHU/kanka" target="_blank">{{ __('front.roadmap.next.title') }}</a></h3>
                            <p class="text-muted">{{ trans('front.roadmap.next.description') }}</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="feature-item">
                            <i class="fab fa-list"></i>
                            <h3><a href="https://trello.com/b/hVjPfOMU/kanka-backlog" target="_blank">{{ __('front.roadmap.backlog.title') }}</a></h3>
                            <p class="text-muted">{{ trans('front.roadmap.backlog.description') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection