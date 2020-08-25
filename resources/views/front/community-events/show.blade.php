<?php /**
 * @var \App\Models\CommunityEvent $model
 * @var \App\Models\CommunityEventEntry $entry
 * */?>
@extends('layouts.front', [
    'title' => __('front/community-events.show.title', ['name' => $model->name]),
    'description' => '',
])

@section('og')
    <meta property="og:description" content="{{ $model->excerpt }}" />
    <meta property="og:url" content="{{ route('community-events.show', $model->getSlug()) }}" />
    <link rel="alternate" type="application/rss+xml" title="{{ __('front/community-events.title') }}" href="{{ url('/feeds/community-events.rss') }}" />
@endsection

@section('content')
    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-12 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ __('front/community-events.title') }}</h1>
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
                    <img class="card-img-top" src="{{ $model->getImageUrl() }}" alt="{{ $model->name }}">
                @endif
                <div class="card-body">
                    <h2 class="card-title mb-1">
                        <a href="{{ route('community-events.show', $model->getSlug()) }}">{{ $model->name }}</a>
                    </h2>
                    <div class="text-muted mb-2">{{ $model->start_at->isoFormat('MMMM D, Y') }} - {{ $model->end_at->isoFormat('MMMM D, Y') }}</div>

                    <div class="card-text">
                            {!! $model->entry !!}

                        <p class="text-muted mt-3">
                            {!! trans_choice('front/community-events.show.participants', $model->entries->count(), ['number' => $model->entries->count()]) !!}
                        </p>

                        @if($model->hasRankedResults())
                            Winners

                            @foreach ($model->rankedResults() as $entry)
                                Winner {{ $entry->id }}
                            @endforeach
                        @endif


                    </div>
                </div>
            </div>



@if(auth()->check() && $model->isOngoing())
            <div class="card mb-4">
                <div class="card-body">
                    @include('partials.errors')
                    <h2 class="cart-title mb 1">
                        {{ __('front/community-events.participate.title') }}
                    </h2>
                    @if($participation = $model->userEntry(auth()->check()))

                        <input type="submit" class="btn btn-primary" value="{{ __('front/community-events.actions.update') }}" />
                    @else
                        <p class="text-muted"> {{ __('front/community-events.participate.description') }}</p>

                        {!! Form::open(['route' => ['community-events.community-event-entries.store', $model], 'method' => 'POST']) !!}

                        <div class="col-md-6 mb-3">
                            <label for="firstName">{{ __('front/community-events.fields.entity_link') }}</label>
                            {!! Form::text('link', null, ['class' => 'form-control', 'placeholder' => __('front/community-events.placeholders.entity_link'), 'required']) !!}
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="firstName">{{ __('front/community-events.fields.entity_link') }}</label>
                            {!! Form::textarea('comment', null, ['class' => 'form-control', 'placeholder' => __('front/community-events.placeholders.comment'), 'rows' => 3]) !!}
                        </div>

                        <div class="col-md-6 mb-3">
                            <input type="submit" class="btn btn-primary" value="{{ __('front/community-events.actions.send') }}" />
                        </div>
                        {!! Form::close() !!}
                    @endif
                </div>
            </div>
@endif

            <div class="mb-4">
                <a href="{{ route('community-events.index') }}">
                    <i class="fa fa-arrow-left"></i> {{ __('front/community-events.actions.return')}}
                </a>
            </div>
        </div>
    </section>
@endsection



@section('scripts')
{{--    <script src="{{ mix('js/community-events.js') }}" defer></script>--}}
@endsection

@section('styles')
{{--    <link href="{{ mix('css/community-events.css') }}" rel="stylesheet">--}}
@endsection
