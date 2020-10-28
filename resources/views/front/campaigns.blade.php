<?php
/** @var \App\Models\Campaign $camp */
?>@extends('layouts.front', [
    'title' => trans('front.menu.campaigns'),
])

@inject('languages', 'App\Services\LanguageService')

@section('og')
    <meta property="og:description" content="{{ __("front.campaigns.description_full") }}" />
    <meta property="og:url" content="{{ route('front.public_campaigns') }}" />
@endsection

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
    <section class="featured-campaigns pb-1" id="featured">
        <div class="container">
            <div class="section-body">
                <h1>{{ trans('front.campaigns.featured.title') }}</h1>
                <p class="text-muted">{{ trans('front.campaigns.featured.description') }}</p>

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
                <h1>{{ trans('front.campaigns.public.title') }}</h1>
                <p class="text-muted">{{ trans('front.campaigns.public.description') }}</p>

                {!! Form::open(['route' => 'front.public_campaigns', 'method' => 'GET']) !!}
                <div class="row mb-3">
                    <div class="col">
                        {!! Form::select('language', array_merge(['' => __('campaigns.fields.locale')], $languages->getSupportedLanguagesList()), request()->get('language'), ['class' => 'form-control']) !!}
                    </div>
                    <div class="col">
                        {!! Form::select('system', array_merge(['' => __('campaigns.fields.system')], \App\Facades\CampaignCache::systems(), ['other' => __('sidebar.other')]), request()->get('system'), ['class' => 'form-control']) !!}
                    </div>
                    <div class="col">
                        {!! Form::select('is_boosted', ['' => __('front.campaigns.public.filters.all'),
 0 => __('front.campaigns.public.filters.unboosted'), 1 => __('front.campaigns.public.filters.boosted')], request()->get('is_boosted'), ['class' => 'form-control']) !!}
                    </div>
                    <div class="col">
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
