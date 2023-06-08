<?php /** @var \App\Models\CommunityVote $model */?>
@extends('layouts.front', [
    'title' => __('front/community-votes.show.title', ['name' => $model->name]),
    'description' => '',
    'skipPerf' => true,
])

@section('og')
    <meta property="og:description" content="{{ $model->excerpt }}" />
    <meta property="og:url" content="{{ route('community-votes.show', $model->getSlug()) }}" />
    <meta property="og:image" content="{{ Img::crop(200)->new()->url('app/backgrounds/kanka_community_vote.png') }}" />
    <link rel="alternate" type="application/rss+xml" title="{{ __('front/community-votes.title') }}" href="{{ url('/feeds/community-votes.rss') }}" />
@endsection

@section('content')

    <section class="community-vote">
        <div class="container">
            <div class="row">
                <div class="col-3 d-none d-md-block">
                    @include('community-votes._recent')
                </div>
                <div class="col-12 col-md-9">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h1 class="card-title mb-1">
                                <a href="{{ route('community-votes.show', $model->getSlug()) }}">{{ $model->name }}</a>
                            </h1>
                            <div class="text-muted mb-2">{{ $model->visible_at->isoFormat('MMMM D, Y') }}</div>

                            <div class="card-text">
                                {!! $model->content !!}


                                @if ($model->isVoting() && (auth()->guest() || !auth()->user()->can('show', $model)))
                                    @if (auth()->check())
                                        <a href="{{ route('settings.subscription') }}" class="btn btn-primary">
                                            {{ __('front/community-votes.actions.subscribe')}}
                                        </a>
                                    @else
                                        <a href="{{ route('front.pricing') }}" class="btn btn-primary">
                                            {{ __('front/community-votes.actions.subscribe')}}
                                        </a>
                                    @endif
                                @else
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
                                @endif
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

                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <a href="{{ route('community-votes.index') }}">
                            <i class="fa-solid fa-arrow-left"></i> {{ __('front/community-votes.actions.return')}}
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
@endsection

