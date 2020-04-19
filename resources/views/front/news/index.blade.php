@extends('layouts.front', [
    'title' => __('front/news.index.title'),
    'description' => __('front/news.index.description'),
    'active' => 'news'
])

@section('og')
    <meta property="og:description" content="{{ __('front/news.description') }}" />
    <meta property="og:url" content="{{ route('front.news') }}" />
    <link rel="alternate" type="application/rss+xml" title="{{ __('front/news.title') }}" href="{{ url('/feeds/news.rss') }}" />
@endsection

@section('content')
    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-7 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ __('front/news.title') }}</h1>
                        <p class="mb-5">{{ __('front/news.description') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section class="features" id="news">
        <div class="container">
            <div class="row">
                <div class="col-3 d-none d-md-block">
                    @include('front.news._recent')
                </div>
                <div class="col-12 col-md-9">
                    <?php /** @var \TCG\Voyager\Models\Post $model */ ?>
                    @foreach ($models as $model)
                        @include('front.news._article', ['preview' => true])
                    @endforeach

                    {{ $models->appends('order', request()->get('order'))->links() }}

                        @include('partials.newsletter', ['source' => 'news'])
                </div>
            </div>
        </div>
    </section>
@endsection
