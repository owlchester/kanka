<?php /** @var \App\Models\CommunityVote $model */?>
@extends('layouts.front', [
    'title' => trans('front/community-votes.show.title', ['name' => $model->name]),
    'description' => '',
])

@section('og')
    <meta property="og:description" content="{{ $model->excerpt }}" />
    <meta property="og:url" content="{{ route('releases.show', $model->getSlug()) }}" />
@endsection

@section('content')
    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-12 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ trans('front.release.title') }}</h1>
                        <p class="mb-5">{{ trans('front.release.description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="community-vote">
        <div class="container">
            <h5 class="text-muted">
                <a href="{{ route('community-votes.show', $model->getSlug()) }}">
                    {{ $model->visible_at->isoFormat('MMMM D, Y') }}
                </a>
            </h5>
            <h2>
                {{ $model->name }}
            </h2>

            <div class="vote-content">
                {!! $model->content !!}
            </div>

            <div class="vote-options @if ($model->isVoting()) vote-ongoing @endif">
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
        </div>
    </section>

    @if ($model->isVoting())
    <input type="hidden" id="community-vote-url" value="{{ route('community-votes.vote', $model->id) }}">
    @endif
@endsection



@section('scripts')
    <script src="{{ mix('js/community-votes.js') }}" defer></script>
@endsection

@section('styles')
    <link href="{{ mix('css/community-votes.css') }}" rel="stylesheet">
@endsection
