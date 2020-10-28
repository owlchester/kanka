<?php /** @var \App\Models\CommunityVote $model */?>
@extends('layouts.front', [
    'title' => __('front/community-votes.show.title', ['name' => $model->name]),
    'description' => '',
])

@section('og')
    <meta property="og:description" content="{{ $model->excerpt }}" />
    <meta property="og:url" content="{{ route('community-votes.show', $model->getSlug()) }}" />
    <link rel="alternate" type="application/rss+xml" title="{{ __('front/community-votes.title') }}" href="{{ url('/feeds/community-votes.rss') }}" />
@endsection

@section('content')
    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-12 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ __('front/community-votes.title') }}</h1>
                        <p class="mb-5">{{ __('front/community-votes.description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="community-vote">
        <div class="container">
            <div class="row">
                <div class="col-3 d-none d-md-block">
                    @include('community-votes._recent')
                </div>
                <div class="col-12 col-md-9">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h2 class="card-title mb-1">
                                <a href="{{ route('community-votes.show', $model->getSlug()) }}">{{ $model->name }}</a>
                            </h2>
                            <div class="text-muted mb-2">{{ $model->visible_at->isoFormat('MMMM D, Y') }}</div>

                            <div class="card-text">
                                @if ($model->isVoting() && (auth()->guest() || !auth()->user()->can('show', $model)))
                                    @include('community-votes._support')
                                @else
                                    {!! $model->content !!}


                                    <div class="vote-options mt-3 @if ($model->isVoting()) vote-ongoing @endif">
                                        @foreach ($model->options() as $key => $text)
                                            <div class="vote-option">
                                                <div class="vote-container">
                                                    <div class="vote-body @if ($model->votedFor($key)) vote-selected @endif" data-option="{{ $key }}">
                                                        <div class="vote-progress" data-width="{{ $key }}" style="width: {{ $model->ballotWidth($key) }}%"></div>
                                                        <div class="vote-name">{{ $text }}</div>
                                                    </div>
                                                </div>
                                                <div class="vote-result"  data-result="{{ $key }}">
                                                    {{ $model->ballotWidth($key) }}%
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <p class="text-muted mt-3">
                                        {!! trans_choice('front/community-votes.show.vote_count', $model->ballots->count(), ['number' => $model->ballots->count()]) !!}
                                    </p>
                                    <p class="text-muted mt-3">
                                        @if ($model->isVoting())
                                            {!! __('front/community-votes.show.voting_until', [
                                                'until' => $model->published_at->isoFormat('MMMM D, Y')
                                            ]) !!}
                                        @else
                                            {!! __('front/community-votes.show.voted_lasted', [
                                                'from' => $model->visible_at->isoFormat('MMMM D, Y'),
                                                'until' => $model->published_at->isoFormat('MMMM D, Y')
                                            ]) !!}
                                        @endif
                                    </p>
                                @endif

                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <a href="{{ route('community-votes.index') }}">
                            <i class="fa fa-arrow-left"></i> {{ __('front/community-votes.actions.return')}}
                        </a>
                    </div>

                    @include('partials.newsletter', ['source' => 'vote'])
                </div>
            </div>

        </div>
    </section>

    @if ($model->isVoting())
    <input type="hidden" id="community-vote-url" value="{{ route('community-votes.vote', $model->id) }}">
    @endif
@endsection



@section('scripts')
<script src="/vendor/jquery/jquery.min.js"></script>
<script src="{{ mix('js/community-votes.js') }}" defer></script>
@endsection

@section('styles')
    <link href="{{ mix('css/community-votes.css') }}" rel="stylesheet">
@endsection
