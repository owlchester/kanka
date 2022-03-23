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
    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-9 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-3">{{ __('front/kb.title') }}</h1>
                        <p class="mb-5">{{ __('front/kb.description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="faq-categories">
        <div class="container">
            <h4>{{ __('front/kb.categories') }}</h4>
            @foreach ($categories as $model)
                @includeWhen($model->sortedFaqs()->count() > 0, 'front.faqs._category')
            @endforeach
        </div>

        <h2 class="mt-5 text-center">{{ __('front.faq.helpers.more') }}</h2>
        <div class="text-center faq-more">
            <a href="{{ config('social.discord') }}" class="btn btn-light">
                <i class="fab fa-discord"></i>
                {{ __('front.help.discord') }}
            </a>
            <a href="{{ route('documentation') }}" class="btn btn-light">
                <i class="fas fa-book"></i>
                {{ __('front.help.documentation') }}
            </a>
            <a href="mailto:{{ config('app.email') }}" class="btn btn-light">
                <i class="fa fa-envelope-open"></i>
                {{ __('front.help.email') }}
            </a>
        </div>
    </section>
@endsection
