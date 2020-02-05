<?php
/**
 * @var \App\Models\CommunityVote $model
 */
?>
@extends('layouts.front', [
    'title' => trans('front/community-votes.title'),
    'description' => trans('front/community-votes.description'),
])

@section('content')
    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-7 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ trans('front/community-votes.title') }}</h1>
                        <p class="mb-5">{{ trans('front/community-votes.description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="community-votes">
        <div class="container">
            <div class="row">
                <div class="col-3">
                    @include('community-votes._recent')
                </div>
                <div class="col-9">
                    @if ($voting)
                        <h4>{{ __('front/community-votes.index.voting') }}</h4>
                        @include('community-votes._vote', ['model' => $voting, 'voting' => true])
                    @endif

                    @foreach ($models as $model)
                        <h4>{{ __('front/community-votes.index.past') }}</h4>
                        @include('community-votes._vote', ['voting' => false])
                    @endforeach

                    {{ $models->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection
