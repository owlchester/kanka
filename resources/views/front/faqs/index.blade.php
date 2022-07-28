<?php
/**
 * @var \App\Models\FaqCategory $categories
 */
?>
@extends('layouts.front', [
    'title' => __('front/kb.title'),
    'description' => __('front/kb.description'),
    'skipPerf' => false,
])

@section('og')
    <meta property="og:description" content="{{ __('front/kb.description') }}" />
    <meta property="og:url" content="{{ route('front.faqs.index') }}" />
@endsection

@section('content')

    <section class="faq-categories">
        <div class="container">

            <div class="mb-5">
                <h1 class="display-4">{{ __('front/kb.title', ['kanka' => config('app.name')]) }}</h1>
                <p class="lead">{{ __('front/kb.description', ['kanka' => config('app.name')]) }}</p>
            </div>

            <h2>{{ __('front/kb.categories') }}</h2>
            @foreach ($categories as $model)
                @includeWhen($model->sortedFaqs()->count() > 0, 'front.faqs._category')
            @endforeach
        </div>

        <h2 class="mt-5 text-center">{{ __('front.faq.helpers.more') }}</h2>
        <div class="text-center faq-more">
            <a href="{{ config('social.discord') }}" class="btn btn-light d-block d-sm-inline-block m-1">
                <i class="fab fa-discord"></i>
                {{ __('front.help.discord') }}
            </a>
            <a href="//docs.kanka.io/en/latest/index.html" target="_blank" class="btn btn-light d-block d-sm-inline-block m-1">
                <i class="fa-solid fa-book"></i>
                {{ __('front.help.documentation') }}
            </a>
            <a href="mailto:{{ config('app.email') }}" class="btn btn-light d-block d-sm-inline-block m-1">
                <i class="fa-solid fa-envelope-open"></i>
                {{ __('front.help.email') }}
            </a>
        </div>
    </section>
@endsection
