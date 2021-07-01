<?php /**
 * @var \App\Models\Faq $model
 * */?>
@extends('layouts.front', [
    'title' => __('front/kb.show.title', ['name' => $model->question]),
    'description' => '',
    'skipPerf' => true,
])

@section('og')
    <meta property="og:description" content="{{ $model->excerpt }}" />
    <meta property="og:url" content="{{ route('front.faqs.show', [$model, 'slug' => \Illuminate\Support\Str::slug($model->question)]) }}" />
@endsection

@section('content')
    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-12 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ $model->question }}</h1>

                        {!! $model->answer !!}

                        <p><a href="{{ route('front.faqs.index') }}">{{ __('front/kb.actions.return') }}</a></p>

                    </div>
                </div>
            </div>
        </div>
    </header>
@endsection

