<?php /**
 * @var \App\Models\CampaignBoost $boost
 * @var \App\Models\Campaign $campaign
 */
?>
@extends('layouts.app', [
    'title' => __('settings.boost.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
])

@section('content')
    @include('partials.errors')
    <div class="box box-solid">
        <div class="box-body">
            <h2 class="page-header with-border">
                {{ __('settings.boost.title') }}
            </h2>

            <p>
                {!! __('settings.boost.benefits.first', ['subscription' => link_to_route('settings.subscription', __('settings.menu.subscription'))]) !!}
            </p>
            <div class="row">
                <div class="col-md-6">
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
                </div>
                <div class="col-md-6">

                    <p>{{ __('settings.boost.benefits.superboost') }}</p>
                    <ul>
                        <li>{{ __('settings.boost.benefits.entity_files') }}</li>
                        <li>{{ __('settings.boost.benefits.campaign_gallery') }}</li>
                        <li>{{ __('settings.boost.benefits.entity_logs') }}</li>
                    </ul>
                </div>
            </div>


            @if (Auth::user()->maxBoosts() > 0)
            <h3 class="page-header with-border">
                {{ __('settings.boost.campaigns', ['max' => Auth::user()->maxBoosts(), 'count' => Auth::user()->boosting()]) }}
            </h3>
            @if ($campaign)
                <div class="row margin-bottom">
                    <div class="col-md-6">
                        <div class="campaign boost" @if ($campaign->image) style="background-image: url('{{ Img::crop(500, 200)->url($campaign->image) }}');" @endif>
                            <div class="actions">
                                <a href="{{ url(App::getLocale() . '/' . $campaign->getMiddlewareLink()) }}" class="campaign-name">
                                    {!! $campaign->name !!}
                                </a>

                                @if(Auth::user()->availableBoosts() > 0)
                                    {!! Form::open(['route' => 'campaign_boosts.store']) !!}
                                    <button type="submit" class="btn btn-primary boost" name="action" value="boost" title="{{ __('settings.boost.buttons.tooltips.boost', ['amount' => 1]) }}" data-toggle="tooltip">
                                        <i class="fa fa-rocket"></i> {{ __('settings.boost.buttons.boost') }}
                                    </button>

                                    @if(Auth::user()->availableBoosts() >= 3)
                                    <button type="submit" class="btn bg-maroon" name="action" value="superboost" title="{{ __('settings.boost.buttons.tooltips.boost', ['amount' => 3]) }}" data-toggle="tooltip">
                                        <i class="fa fa-rocket"></i> {{ __('settings.boost.buttons.superboost') }}
                                    </button>
                                    @else
                                        <button type="submit" disabled="disabled" class="btn bg-maroon" value="superboost" title="{{ __('settings.boost.buttons.tooltips.boost', ['amount' => 3]) }}" data-toggle="tooltip">
                                            <i class="fa fa-rocket"></i> {{ __('settings.boost.buttons.superboost') }}
                                        </button>
                                    @endif
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
                </div>
            @endif
                <div class="row">
                    @foreach ($boosts as $boost)
                    <div class="col-md-6 margin-bottom">
                        <div class="campaign" @if ($boost->campaign->image) style="background-image: url('{{ Img::crop(500, 200)->url($boost->campaign->image) }}');" @endif>
                            <div class="actions">
                                <a href="{{ url(App::getLocale() . '/' . $boost->campaign->getMiddlewareLink()) }}" class="campaign-name">
                                    {!! $boost->campaign->name !!}
                                </a>

                                @if(!$boost->campaign->boosted(true))
                                        @if(auth()->user()->availableBoosts() >= 2)
                                        {!! Form::model($boost, ['route' => ['campaign_boosts.update', $boost], 'method' => 'PATCH']) !!}
                                            <button type="submit" class="btn bg-maroon" value="superboost" title="{{ __('settings.boost.buttons.tooltips.boost', ['amount' => 3]) }}" data-toggle="tooltip">
                                                <i class="fa fa-rocket"></i> {{ __('settings.boost.buttons.superboost') }}
                                            </button>
                                        {!! Form::close() !!}
                                        @else
                                        <button type="submit" disabled="disabled" class="btn bg-maroon" value="superboost" title="{{ __('settings.boost.buttons.tooltips.boost', ['amount' => 3]) }}" data-toggle="tooltip">
                                            <i class="fa fa-rocket"></i> {{ __('settings.boost.buttons.superboost') }}
                                        </button>
                                        @endif
                                @endif
                                @can('destroy', $boost)
                                    <a href="#" class="delete-confirm btn btn-danger" data-name="{!! $boost->campaign->name !!}" data-toggle="modal" data-target="#unboost-confirm" data-delete-target="delete-confirm-form-{{ $boost->id }}" data-confirm-target="#unboost-confirm-name">
                                        <i class="fa fa-trash" aria-hidden="true"></i> {{ __('crud.remove') }}
                                    </a>
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['campaign_boosts.destroy', $boost->id], 'style' => 'display:inline', 'id' => 'delete-confirm-form-' . $boost->id]) !!}
                                    {!! Form::close() !!}
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
            <p class="help-block">{{ __('settings.boost.benefits.third', [
                'boost_button' => __('campaigns.show.actions.boost'),
                'edit_button' => __('campaigns.show.actions.edit')
            ]) }}</p>
        </div>
    </div>
@endsection

@section('modals')
    <div class="modal fade" id="unboost-confirm" tabindex="-1" role="dialog" aria-labelledby="unboostConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ __('settings.boost.unboost.title') }}</h4>
                </div>
                <div class="modal-body">
                    <p id="unboost-confirm-text">
                        {!! __('settings.boost.unboost.description', ['tag' => '<b><span id="unboost-confirm-name"></span></b>']) !!}
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('crud.cancel') }}</button>
                    <button type="button" class="btn btn-danger delete-confirm-submit">
                        <span class="fa fa-trash"></span> {{ __('crud.remove') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('styles')
    @parent
    <link href="{{ mix('css/settings.css') }}" rel="stylesheet">
@endsection
