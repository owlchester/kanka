<?php
/**
 * @var \App\Models\CommunityVote $model
 */
?>
@extends('layouts.front', [
    'title' => __('front/community-votes.title'),
    'description' => __('front/community-votes.description'),
    'skipPerf' => true,
])

@section('og')
    <meta property="og:description" content="{{ __('front/community-votes.description') }}" />
    <meta property="og:url" content="{{ route('community-votes.index') }}" />
    <link rel="alternate" type="application/rss+xml" title="{{ __('front/community-votes.title') }}" href="{{ url('/feeds/community-votes.rss') }}" />
@endsection

@section('content')
    <section class="community-votes">
        <div class="container">

            <div class="mb-5">
                <h1 class="display-4">{{ __('front/community-votes.title', ['kanka' => config('app.name')]) }}</h1>
                <p class="lead">{{ __('front/community-votes.description', ['kanka' => config('app.name')]) }}</p>
            </div>

            <div class="row">
                <div class="col-3">
                    @include('community-votes._recent')
                </div>
                <div class="col-9">
                    @if ($voting)
                        <h4>{{ __('front/community-votes.index.voting') }}</h4>
                        @include('community-votes._vote', ['model' => $voting, 'voting' => true])
                    @endif

                    <h4>{{ __('front/community-votes.index.past') }}</h4>
                    @foreach ($models as $model)
                        @include('community-votes._vote', ['voting' => false])
                    @endforeach

                    {{ $models->links() }}


                    @include('partials.newsletter', ['source' => 'vote'])
                </div>
            </div>
        </div>
    </section>
@endsection
