<?php
/**
 * @var \App\Models\CommunityVote $model
 */
?>
@extends('layouts.front', [
    'title' => trans('front/community-votes.index.title'),
    'description' => trans('front/community-votes.index.description'),
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
            @if ($voting)
                <h1>{{ __('front/community-votes.index.voting') }}</h1>
                @include('community-votes._vote', ['model' => $voting, 'voting' => true])
            @endif

            @foreach ($models as $model)
                <h1>{{ __('front/community-votes.index.past') }}</h1>
                @include('community-votes._vote', ['voting' => false])
            @endforeach

            {{ $models->links() }}
        </div>
    </section>
@endsection
