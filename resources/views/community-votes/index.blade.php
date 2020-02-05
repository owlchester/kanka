<?php
/**
 * @var \App\Models\CommunityVote $model
 * @var \App\Models\Scopes\CommunityVoteScopes $voting
 */
?>
@extends('layouts.front', [
    'title' => trans('community-votes.index.title'),
    'description' => trans('community-votes.index.description'),
])

@section('content')
    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-7 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ trans('front.community-votes.title') }}</h1>
                        <p class="mb-5">{{ trans('front.community-votes.description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="community-votes">
        <div class="container">
            @foreach ($models as $model)
                <div class="card">
                    <h4 class="card-title">
                        <a href="{{ route('community-votes.show', $model->getSlug()) }}">
                            {{ $model->title }}
                        </a>
                    </h4>
                    <div class="card-body">
                        {!! $model->excerpt !!}
                    </div>
                </div>
            @endforeach

            {{ $models->links() }}
        </div>
    </section>
@endsection
