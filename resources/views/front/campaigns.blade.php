@extends('layouts.front', [
    'title' => trans('front.menu.campaigns'),
    'menus' => [
        'campaigns',
    ],
    'menu_js' => false,
])
@section('content')

    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-12 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-5">{{ trans('front.campaigns.title') }}</h1>
                        <p class="mb-5">{{ trans('front.campaigns.description_full') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    @if ($featured->count() > 0)
    <section class="featured-campaigns" id="featured">
        <div class="container">
            <div class="section-body">
                <h1>{{ trans('front.campaigns.featured.title') }}</h1>
                <p class="text-muted">{{ trans('front.campaigns.featured.description') }}</p>

                <div class="row">
                    @foreach ($featured as $camp)
                    <div class="col-lg-4 col-md-6">
                        <a class="campaign" href="{{ url(app()->getLocale() . '/' . $camp->getMiddlewareLink()) }}" title="{{ $camp->name }}">
                                <div class="image-wrapper" @if ($camp->image) style="background-color: transparent !important; background-image: url('{{ $camp->getImageUrl() }}')" @endif>
                                </div>
                            <h4 class="campaign-title">
                                <span class="pull-right text-right">
                                    @if ($camp->locale)
                                    <span class="label label-default" title="{{ __('languages.codes.' . $camp->locale) }}">{{ $camp->locale }}</span>
                                    @endif
                                    @if (!empty($camp->system))
                                        <span class="label label-default">{{ $camp->system }}</span>
                                    @endif
                                </span>
                                {{ $camp->name }}
                            </h4>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    @if ($campaigns->count() > 0)
        <section class="campaigns" id="public-campaigns">
            <div class="container">
                <div class="section-body">
                    <h1>{{ trans('front.campaigns.public.title') }}</h1>
                    <p class="text-muted">{{ trans('front.campaigns.public.description') }}</p>

                    <div class="row">
                        @foreach ($campaigns as $camp)
                            <div class="col-lg-3 col-md-4">
                                <a class="campaign" href="{{ url(app()->getLocale() . '/' . $camp->getMiddlewareLink()) }}" title="{{ $camp->name }}" >
                                    <div class="image-wrapper small-campaign" @if ($camp->image) style="background-color: transparent !important; background-image: url('{{ $camp->getImageUrl() }}')" @endif>
                                    </div>
                                    <h4 class="campaign-title">
                                        <span class="pull-right text-right">
                                            @if ($camp->locale)
                                                <span class="label label-default " title="{{ __('languages.codes.' . $camp->locale) }}">{{
                                                 $camp->locale }}</span>
                                            @endif
                                            @if (!empty($camp->system))
                                                <span class="label label-default margin-r-5">{{ $camp->system }}</span>
                                            @endif
                                        </span>
                                        {{ $camp->name }}


                                    </h4>
                                </a>
                            </div>
                        @endforeach
                    </div>

                    {{ $campaigns->fragment('public-campaigns')->links() }}
                </div>
            </div>
        </section>
    @endif
@endsection