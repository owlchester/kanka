@extends('layouts.front', [
    'title' => trans('front.menu.roadmap'),
])
@section('og')
    <meta property="og:description" content="{{ __('front.roadmap.description', ['kanka' => config('app.name')]) }}" />
    <meta property="og:url" content="{{ route('front.roadmap') }}" />
@endsection
@section('content')

    <section class="features" id="roadmaps">
        <div class="container">
            <div class="section-body">

                <div class="mb-5">
                    <h1 class="display-4">{{ __('front.roadmap.title', ['kanka' => config('app.name')]) }}</h1>
                    <p class="lead">{{ __('front.roadmap.description', ['kanka' => config('app.name')]) }}</p>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="feature-item">
                            <i class="fa-solid fa-list"></i>
                            <h3><a href="https://trello.com/b/62aOwCHU/kanka" target="_blank">{{ __('front.roadmap.next.title') }}</a></h3>
                            <p class="text-muted">{!! __('front.roadmap.next.description', ['community_vote' => link_to_route('community-votes.index', __('front/community-votes.title'))]) !!}</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="feature-item">
                            <i class="fa-solid fa-list"></i>
                            <h3><a href="https://trello.com/b/hVjPfOMU/kanka-backlog" target="_blank">{{ __('front.roadmap.featured_requests.title') }}</a></h3>
                            <p class="text-muted">{{ trans('front.roadmap.backlog.description') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
