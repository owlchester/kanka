<?php
/**
 * @var \App\Models\CommunityEvent $model
 */
?>
@extends('layouts.front', [
    'title' => __('front/community-events.title'),
    'description' => __('front/community-events.description'),
    'skipPerf' => true,
])

@section('og')
    <meta property="og:description" content="{{ __('front/community-events.description') }}" />
    <meta property="og:url" content="{{ route('community-events.index') }}" />
    <link rel="alternate" type="application/rss+xml" title="{{ __('front/community-events.title') }}" href="{{ url('/feeds/community-events.rss') }}" />
@endsection

@section('content')

    <section class="community-events">
        <div class="container">

            <div class="section-body">
                <div class="mb-5">
                    <h1 class="display-4">{{ __('front/community-events.title', ['kanka' => config('app.name')]) }}</h1>
                    <p class="lead">{{ __('front/community-events.description', ['kanka' => config('app.name')]) }}</p>
                </div>

@if (!$ongoing->isEmpty())
            <h2>{{ __('front/community-events.index.ongoing') }}</h2>
            @foreach($ongoing as $model)
                @include('front.community-events._event', ['model' => $model, 'ongoing' => true])
            @endforeach
@endif

@if ($finished->total() > 0)
            <h2>{{ __('front/community-events.index.past') }}</h2>
            @foreach ($finished as $model)
                @include('front.community-events._event', ['ongoing' => false])
            @endforeach

            {{ $finished->links() }}
@endif
        </div>
    </section>
@endsection
