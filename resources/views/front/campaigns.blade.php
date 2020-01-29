<?php
/** @var \App\Models\Campaign $camp */
?>@extends('layouts.front', [
    'title' => trans('front.menu.campaigns'),
])
@section('content')

    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-7 my-auto">
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
                            <div class="image-wrapper @if ($camp->image)" style="background-color: transparent !important; background-image: url('{{ $camp->getImageUrl() }}') @else no-image @endif">
                                <div class="labels">
                                    <span class="label label-default count" title="{{ __('campaigns.fields.entity_count') }}">
                                        <i class="fa fa-eye"></i> {{ number_format($camp->visible_entity_count) }}
                                    </span>
                                    @if ($camp->locale)
                                        <span class="label label-default" title="{{ __('languages.codes.' . $camp->locale) }}">{{ $camp->locale }}</span>
                                    @endif
                                    @if (!empty($camp->system))
                                        <span class="label label-default" title="{{ __('campaigns.fields.system') }}">{{ $camp->system }}</span>
                                    @endif
                                    @if ($camp->boosted())
                                        <span class="label label-default" title="{{ __('campaigns.panels.boosted') }}">
                                            <i class="fa fa-rocket"></i>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <h4 class="campaign-title">
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
                                    <div class="image-wrapper small-campaign @if ($camp->image)" style="background-color: transparent !important; background-image: url('{{ $camp->getImageUrl() }}')" @else no-image @endif">
                                        <div class="labels">
                                            <span class="label label-default count" title="{{ __('campaigns.fields.entity_count') }}">
                                                <i class="fa fa-eye"></i> {{ number_format($camp->visible_entity_count) }}
                                            </span>
                                            @if ($camp->locale)
                                                <span class="label label-default" title="{{ __('languages.codes.' . $camp->locale) }}">
                                                    {{ $camp->locale }}
                                                </span>
                                            @endif
                                            @if (!empty($camp->system))
                                                <span class="label label-default" title="{{ __('campaigns.fields.system') }}">
                                                    {{ $camp->system }}
                                                </span>
                                            @endif
                                            @if ($camp->boosted())
                                                <span class="label label-default" title="{{ __('campaigns.panels.boosted') }}">
                                                    <i class="fa fa-rocket"></i>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <h4 class="campaign-title">
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