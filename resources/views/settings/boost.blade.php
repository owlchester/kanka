<?php /**
 * @var \App\Models\CampaignBoost $boost
 * @var \App\Models\Campaign $campaign
 */
?>
@extends('layouts.app', [
    'title' => trans('settings.boost.title'),
    'breadcrumbs' => false
])

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="col-lg-2 col-sm-4 col-xs-4">
            @include('settings.menu', ['active' => 'boost'])
        </div>
        <div class="col-lg-10 col-sm-8 col-xs-8">
            <div class="box box-solid">
                <div class="box-body">
                    <h2 class="page-header with-border">
                        {{ trans('settings.boost.title') }}
                    </h2>

                    <p>
                        {!! __('settings.boost.benefits.first', ['patreon' => link_to_route('settings.patreon', __('settings.patreon.title'))]) !!}
                    </p>
                    <p>{{ __('settings.boost.benefits.second') }}</p>
                    <ul>
                        <li>{{ __('settings.boost.benefits.theme') }}</li>
                        <li>{{ __('settings.boost.benefits.tooltip') }}</li>
                        <li>{{ __('settings.boost.benefits.header') }}</li>
                        <li>{{ __('settings.boost.benefits.more') }}</li>
                    </ul>

                    @if (Auth::user()->maxBoosts() > 0)
                    <h3 class="page-header with-border">
                        {{ __('settings.boost.campaigns', ['max' => Auth::user()->maxBoosts(), 'count' => Auth::user()->boosting()]) }}
                    </h3>
                        <div class="row">
                            @foreach ($boosts as $boost)
                            <div class="col-md-4">
                                <div class="campaign" @if ($boost->campaign->image) style="background-image: url('{{ Storage::url($boost->campaign->image) }}');" @endif>
                                    <div class="actions">
                                    <a href="{{ url(App::getLocale() . '/' . $boost->campaign->getMiddlewareLink()) }}">{!! $boost->campaign->name !!}</a><br />

                                    @can('destroy', $boost)
                                    <a href="#" class="delete-confirm btn btn-danger" data-name="{{ $boost->campaign->name }}" data-toggle="modal" data-target="#delete-confirm">
                                        <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                                    </a>
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['campaign_boost.destroy', $boost->id], 'style' => 'display:inline', 'id' => 'delete-confirm-form']) !!}
                                    {!! Form::close() !!}
                                    @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @if ($campaign)
                                <div class="col-md-4">
                                    <div class="campaign boost" @if ($campaign->image) style="background-image: url('{{ Storage::url($campaign->image) }}');" @endif>
                                        <div class="actions">
                                            <a href="{{ url(App::getLocale() . '/' . $campaign->getMiddlewareLink()) }}">{!! $campaign->name !!}</a>

                                            {!! Form::open(['route' => 'campaign_boost.store']) !!}
                                            {!! Form::submit(__('settings.boost.buttons.boost'), ['class' => 'btn btn-primary boost']) !!}
                                            {!! Form::hidden('campaign_id', $campaign->id) !!}
                                            {!! Form::close(); !!}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection


@section('styles')
    @parent
    <link href="{{ mix('css/settings.css') }}" rel="stylesheet">
@endsection