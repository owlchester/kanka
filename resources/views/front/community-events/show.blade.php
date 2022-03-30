<?php /**
 * @var \App\Models\CommunityEvent $model
 * @var \App\Models\CommunityEventEntry $entry
 * */?>
@extends('layouts.front', [
    'title' => $model->name,
    'description' => '',
    'skipPerf' => true,
])

@section('og')
    <meta property="og:description" content="{{ $model->excerpt }}" />
    <meta property="og:url" content="{{ route('community-events.show', $model) }}" />
    @if ($model->image)<meta property="og:image" content="{{ $model->getImageUrl(280, 280)  }}" />@endif
    <link rel="alternate" type="application/rss+xml" title="{{ __('front/community-events.title') }}" href="{{ url('/feeds/community-events.rss') }}" />
@endsection

@section('content')
    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-12 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-3">{{ __('front/community-events.title') }}</h1>
                        <p class="mb-5">{{ __('front/community-events.description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="community-event">
        <div class="container">
            <div class="card mb-4">
                @if (!empty($model->image))
                    <img class="card-img-top" src="{{ $model->getImageUrl(1200, 280) }}" alt="{{ $model->name }}">
                @endif
                <div class="card-body">
                    <h2 class="card-title mb-1">
                        <a href="{{ route('community-events.show', $model) }}">{{ $model->name }}</a>
                    </h2>
                    <div class="text-muted mb-2">{{ $model->start_at->isoFormat('MMMM Do Y') }} - {{ $model->end_at->isoFormat('MMMM Do Y') }}</div>

                    <div class="card-text">
                            {!! $model->entry !!}

                        <p class="text-muted mt-3" id="event-form">
                            {!! trans_choice('front/community-events.show.participants', $model->entries->count(), ['number' => $model->entries->count()]) !!}
                        </p>
                    </div>
                </div>
            </div>


            <div class="card mb-4">
                <div class="card-body">
                @if($model->isScheduled())
                    <p class="text-muted">{{ __('front/community-events.results.scheduled', ['start' => $model->start_at->isoFormat('MMMM Do Y, hh:mm a')]) }}</p>
                @elseif($model->isOngoing())
                    @include('front.community-events._participate')
                @elseif($model->hasRankedResults())
                    @include('front.community-events._results')
                @else
                    <p class="text-muted">{{ __('front/community-events.results.waiting_results') }}</p>
                @endif
                </div>
            </div>

            <div class="mb-4">
                <a href="{{ route('community-events.index') }}">
                    <i class="fa fa-arrow-left"></i> {{ __('front/community-events.actions.return')}}
                </a>
            </div>
        </div>
    </section>
@endsection
