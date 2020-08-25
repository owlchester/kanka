<?php
/**
 * @var \App\Models\CommunityEvent $model
 */
?>
@extends('layouts.front', [
    'title' => __('front/community-events.title'),
    'description' => __('front/community-events.description'),
])

@section('og')
    <meta property="og:description" content="{{ __('front/community-events.description') }}" />
    <meta property="og:url" content="{{ route('community-events.index') }}" />
    <link rel="alternate" type="application/rss+xml" title="{{ __('front/community-events.title') }}" href="{{ url('/feeds/community-events.rss') }}" />
@endsection

@section('content')
    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-7 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ __('front/community-events.title') }}</h1>
                        <p class="mb-5">{{ __('front/community-events.description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="community-events">
        <div class="container">
@if (!$ongoing->isEmpty())
                <h4>{{ __('front/community-events.index.ongoing') }}</h4>
                @foreach($ongoing as $model)
                    @include('front.community-events._event', ['model' => $model, 'ongoing' => true])
                @endforeach
@endif

@if ($finished->total() > 0)
            <h4>{{ __('front/community-events.index.past') }}</h4>
            @foreach ($finished as $model)
                @include('front.community-events._event', ['ongoing' => false])
            @endforeach

            {{ $finished->links() }}
@endif
        </div>
    </section>
@endsection
