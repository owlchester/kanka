<?php /**
 * @var \App\Models\CampaignBoost $boost
 * @var \App\Models\Campaign $campaign
 */
?>
@extends('layouts.app', [
    'title' => trans('settings.boost.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
])

@section('content')
    @include('partials.errors')
    <div class="box box-solid">
        <div class="box-body">
            <h2 class="page-header with-border">
                {{ trans('settings.boost.title') }}
            </h2>

            <p>
                {!! __('settings.boost.benefits.first', ['subscription' => link_to_route('settings.subscription', __('settings.menu.subscription'))]) !!}
            </p>
            <p>{{ __('settings.boost.benefits.second') }}</p>
            <ul>
                <li>{{ __('settings.boost.benefits.theme') }}</li>
                <li>{{ __('settings.boost.benefits.tooltip') }}</li>
                <li>{{ __('settings.boost.benefits.images') }}</li>
                <li>{{ __('settings.boost.benefits.header') }}</li>
                <li>{{ __('settings.boost.benefits.upload') }}</li>
                <li><a href="{{ route('front.features', '#boost') }}">
                    {{ __('settings.boost.benefits.more') }}
                    </a></li>
            </ul>

            <p class="help-block">{{ __('settings.boost.benefits.third', [
                'boost_button' => __('campaigns.show.actions.boost'),
                'edit_button' => __('campaigns.show.actions.edit')
            ]) }}</p>

            @if (Auth::user()->maxBoosts() > 0)
            <h3 class="page-header with-border">
                {{ __('settings.boost.campaigns', ['max' => Auth::user()->maxBoosts(), 'count' => Auth::user()->boosting()]) }}
            </h3>
                <div class="row">
                    @foreach ($boosts as $boost)
                    <div class="col-md-4 margin-bottom">
                        <div class="campaign" @if ($boost->campaign->image) style="background-image: url('{{ Img::crop(500, 200)->url($boost->campaign->image) }}');" @endif>
                            <div class="actions">
                            <a href="{{ url(App::getLocale() . '/' . $boost->campaign->getMiddlewareLink()) }}">{!! $boost->campaign->name !!}</a><br />

                            @can('destroy', $boost)
                            <a href="#" class="delete-confirm btn btn-danger" data-name="{{ $boost->campaign->name }}" data-toggle="modal" data-target="#delete-confirm" data-delete-target="delete-confirm-form-{{ $boost->id }}">
                                <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                            </a>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['campaign_boost.destroy', $boost->id], 'style' => 'display:inline', 'id' => 'delete-confirm-form-' . $boost->id]) !!}
                            {!! Form::close() !!}
                            @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @if ($campaign)
                        <div class="col-md-4">
                            <div class="campaign boost" @if ($campaign->image) style="background-image: url('{{ Img::crop(500, 200)->url($campaign->image) }}');" @endif>
                                <div class="actions">
                                    <a href="{{ url(App::getLocale() . '/' . $campaign->getMiddlewareLink()) }}">{!! $campaign->name !!}</a>

                                    @if(Auth::user()->availableBoosts() > 0)
                                    {!! Form::open(['route' => 'campaign_boost.store']) !!}
                                    <button type="submit" class="btn btn-primary boost">
                                        <i class="fa fa-rocket"></i> {{ __('settings.boost.buttons.boost') }}
                                    </button>
                                    {!! Form::hidden('campaign_id', $campaign->id) !!}
                                    {!! Form::close(); !!}
                                    @else
                                    <button class="btn btn-default boost" disabled="disabled">
                                        {{ __('settings.boost.buttons.boost')  }}
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endsection


@section('styles')
    @parent
    <link href="{{ mix('css/settings.css') }}" rel="stylesheet">
@endsection
