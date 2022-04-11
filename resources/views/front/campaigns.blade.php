<?php
/** @var \App\Models\Campaign $camp */
?>@extends('layouts.front', [
    'title' => __('front.menu.campaigns'),
    'active' => 'public-campaigns',
    'skipPerf' => true,
])

@inject('languages', 'App\Services\LanguageService')

@section('og')
    <meta property="og:description" content="{{ __("front.campaigns.description_full", ['kanka' => config('app.name')]) }}" />
    <meta property="og:url" content="{{ route('front.public_campaigns') }}" />
@endsection

@section('content')
    <header class="masthead reduced-masthead">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-lg-9 my-auto">
                    <div class="header-content mx-auto">
                        <h1 class="mb-3">{{ __('front.campaigns.title') }}</h1>
                        <p class="mb-5">{{ __('front.campaigns.description_full', ['kanka' => config('app.name')]) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    @if ($featured->count() > 0)
    <section class="featured-campaigns pb-1" id="featured">
        <div class="container">
            <div class="section-body">
                <h1>{{ __('front.campaigns.featured.title') }}</h1>
                <p class="text-muted">{{ __('front.campaigns.featured.description') }}</p>

                <div class="row">
                    @foreach ($featured as $camp)
                    <div class="col-lg-4 col-md-6">
                        @include('front._campaign', ['campaign' => $camp, 'featured' => true])
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    <section class="campaigns" id="public-campaigns">
        <div class="container">
            <div class="section-body">
                <h1>{{ __('front.campaigns.public.title') }}</h1>
                <p class="text-muted">{{ __('front.campaigns.public.description') }}</p>

                {!! Form::open(['route' => ['front.public_campaigns', '#public-campaigns'], 'method' => 'GET']) !!}
                <div class="row mb-3">
                    <div class="col-sm-2 mb-1">
                        {!! Form::select('language', array_merge(['' => __('campaigns.fields.locale')], $languages->getSupportedLanguagesList()), request()->get('language'), ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-2 mb-1">
                        {!! Form::select('system', array_merge(['' => __('campaigns.fields.system')], \App\Facades\CampaignCache::systems(), ['other' => __('sidebar.other')]), request()->get('system'), ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-2 mb-1">
                        {!! Form::select('is_boosted', ['' => __('front.campaigns.public.filters.all'),
 0 => __('front.campaigns.public.filters.unboosted'), 1 => __('front.campaigns.public.filters.boosted')], request()->get('is_boosted'), ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-2 mb-1">
                        {!! Form::select('is_open', ['' => __('front.campaigns.open.filters.all'),
 1 => __('front.campaigns.open.filters.open'), 0 => __('front.campaigns.open.filters.closed')], request()->get('is_open'), ['class' => 'form-control']) !!}
                    </div>
                    <div class="col-sm-2 mb-1">
                        <input type="submit" class="btn btn-primary" value="{{ __('crud.actions.apply') }}" />
                    </div>
                </div>
                {!! Form::close() !!}

                @if (empty($campaigns))
                <p class="text-muted">{{ __('front.campaigns.public.no-results') }}</p>
                @else
                <div class="row">
                    @foreach ($campaigns as $camp)
                        <div class="col-lg-3 col-md-4">
                            @include('front._campaign', ['campaign' => $camp, 'featured' => false])
                        </div>
                    @endforeach
                </div>

                {{ $campaigns->fragment('public-campaigns')
                    ->appends('language', request()->get('language'))
                    ->appends('system', request()->get('system'))
                    ->appends('is_boosted', request()->get('is_boosted'))
                    ->links() }}
                @endif
            </div>
        </div>
    </section>
@endsection
