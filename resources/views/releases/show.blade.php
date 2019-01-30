<?php /** @var \App\Models\Release $model */?>
@extends('layouts.front', [
    'title' => trans('releases.show.title', ['name' => $model->title]),
    'description' => '',
    'menus' => [
        'releases'
    ],
    'menu_js' => false,
])

@section('og')
    <meta property="og:title" content="{{ $model->title }} - {{ config('app.name') }}" />
    <meta property="og:description" content="{{ $model->excerpt }}" />
    <meta property="og:url" content="{{ route('releases.show', $model->getSlug()) }}" />
    <meta property="og:site_name" content="{{ config('app.url') }}" />
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

    <section class="features" id="releases">
        <div class="container">
            <h2>{{ $model->title }}</h2>

            <p class="text-muted">
                {{ trans('releases.post.footer', ['date' => $model->updated_at->diffForHumans(), 'name' => $model->authorId->name]) }}
            </p>

            {!! $model->body !!}
            <p><a href="{{ route('releases.index') }}">{{ trans('releases.show.return') }}</a></p>
        </div>
    </section>
@endsection
