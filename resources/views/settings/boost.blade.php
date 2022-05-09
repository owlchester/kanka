<?php /**
 * @var \App\Models\CampaignBoost $boost
 * @var \App\Models\Campaign $campaign
 */
?>
@extends('layouts.app', [
    'title' => __('settings/boosters.title'),
    'breadcrumbs' => false,
    'sidebar' => 'settings',
    'noads' => true,
])

@section('content')
    @include('partials.errors')
        <div class="box">
            <div class="box-body">
                <p>
                    {!! __('settings/boosters.intro.first', ['subscription' => link_to_route('settings.subscription', __('settings.menu.subscription'))]) !!}
                </p>
                <p>{!! __('settings/boosters.intro.anyone', ['public' => link_to_route('front.public_campaigns', __('front.menu.campaigns'))]) !!}</p>
                <p>{{ __('settings/boosters.intro.data') }}</p>
            </div>

        </div>

    <div class="row">
        <div class="col-md-6">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        {{ __('settings.boost.benefits.headers.boosted') }}
                    </h3>
                </div>
                <div class="box-body">
                    <p>{!!
    __('settings/boosters.benefits.boosted', [
        'one' => '<code>1</code>',
        'marketplace' => link_to('//marketplace.kanka.io', __('front.menu.marketplace'), ['target' => '_blank']),
        'more' => link_to_route('front.pricing', __('settings/boosters.benefits.more'), ['#boost'], ['target' => '_blank'])
]) !!}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        {{ __('settings.boost.benefits.headers.superboosted') }}
                    </h3>
                </div>
                <div class="box-body">
                    <p>{!!
    __('settings/boosters.benefits.superboosted', [
        'amount' => '<code>3</code>',
        'more' => link_to_route('front.pricing', __('settings/boosters.benefits.more'), ['#boost'], ['target' => '_blank'])
]) !!}</p>
                </div>
            </div>
        </div>
    </div>


    @if (auth()->user()->maxBoosts() > 0)
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">
                    {{ __('settings.boost.available_boosts', ['max' => auth()->user()->maxBoosts(), 'amount' => auth()->user()->availableBoosts()]) }}
                </h3>
                <div class="box-tools">
                    <button class="btn btn-box-tool" data-toggle="modal"
                            data-target="#more-boosters">
                        <i class="fa-solid fa-question-circle"></i> {{ __('settings.boost.modals.more.action') }}
                    </button>
                </div>
            </div>
            <div class="box-body">
            @if ($campaign)
                <div class="row margin-bottom">
                    <div class="col-md-6">
                        <div class="campaign boost" @if ($campaign->image) style="background-image: url('{{ Img::crop(500, 200)->url($campaign->image) }}');" @endif>
                            <div class="actions">
                                <a href="{{ url(App::getLocale() . '/' . $campaign->getMiddlewareLink()) }}" class="campaign-name">
                                    {!! $campaign->name !!}
                                </a>

                                @if(auth()->user()->availableBoosts() > 0)
                                    {!! Form::open(['route' => 'campaign_boosts.store']) !!}
                                    <button type="submit" class="btn btn-primary boost" name="action" value="boost" title="{{ __('settings.boost.buttons.tooltips.boost', ['amount' => 1]) }}" data-toggle="tooltip">
                                        <i class="fa-solid fa-rocket"></i> {{ __('settings.boost.buttons.boost') }}
                                    </button>

                                    @if(auth()->user()->availableBoosts() >= 3)
                                    <button type="submit" class="btn bg-maroon" name="action" value="superboost" title="{{ __('settings.boost.buttons.tooltips.boost', ['amount' => 3]) }}" data-toggle="tooltip">
                                        <i class="fa-solid fa-rocket"></i> {{ __('settings.boost.buttons.superboost') }}
                                    </button>
                                    @else
                                        <button type="submit" disabled="disabled" class="btn bg-maroon" value="superboost" title="{{ __('settings.boost.buttons.tooltips.boost', ['amount' => 3]) }}" data-toggle="tooltip">
                                            <i class="fa-solid fa-rocket"></i> {{ __('settings.boost.buttons.superboost') }}
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
                                                <i class="fa-solid fa-rocket"></i> {{ __('settings.boost.buttons.superboost') }}
                                            </button>
                                        {!! Form::close() !!}
                                        @else
                                        <button type="submit" disabled="disabled" class="btn bg-maroon" value="superboost" title="{{ __('settings.boost.buttons.tooltips.boost', ['amount' => 3]) }}" data-toggle="tooltip">
                                            <i class="fa-solid fa-rocket"></i> {{ __('settings.boost.buttons.superboost') }}
                                        </button>
                                        @endif
                                @endif
                                @can('destroy', $boost)
                                    <a href="#" class="delete-confirm btn btn-danger" data-name="{!! $boost->campaign->name !!}" data-toggle="modal" data-target="#unboost-confirm" data-delete-target="delete-confirm-form-{{ $boost->id }}" data-confirm-target="#unboost-confirm-name">
                                        {{ __('settings.boost.buttons.unboost') }}
                                    </a>
                                    {!! Form::open(['method' => 'DELETE', 'route' => ['campaign_boosts.destroy', $boost->id], 'style' => 'display:inline', 'id' => 'delete-confirm-form-' . $boost->id]) !!}
                                    {!! Form::close() !!}
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach

                    @foreach ($userCampaigns as $userCampaign)
                        <div class="col-md-6 margin-bottom">
                            <div class="campaign" @if ($userCampaign->image) style="background-image: url('{{ Img::crop(500, 200)->url($userCampaign->image) }}');" @endif>
                                <div class="actions">
                                    <a href="{{ url(App::getLocale() . '/' . $userCampaign->getMiddlewareLink()) }}" class="campaign-name">
                                        {!! $userCampaign->name !!}
                                    </a>

                                    @if(auth()->user()->availableBoosts() > 0)
                                        {!! Form::open(['route' => 'campaign_boosts.store']) !!}
                                        <button type="submit" class="btn btn-primary boost" name="action" value="boost" title="{{ __('settings.boost.buttons.tooltips.boost', ['amount' => 1]) }}" data-toggle="tooltip">
                                            <i class="fa-solid fa-rocket"></i> {{ __('settings.boost.buttons.boost') }}
                                        </button>

                                        @if(auth()->user()->availableBoosts() >= 3)
                                            <button type="submit" class="btn bg-maroon" name="action" value="superboost" title="{{ __('settings.boost.buttons.tooltips.superboost', ['amount' => 3]) }}" data-toggle="tooltip">
                                                <i class="fa-solid fa-rocket"></i> {{ __('settings.boost.buttons.superboost') }}
                                            </button>
                                        @else
                                            <button type="submit" disabled="disabled" class="btn bg-maroon" value="superboost" title="{{ __('settings.boost.buttons.tooltips.boost', ['amount' => 3]) }}" data-toggle="tooltip">
                                                <i class="fa-solid fa-rocket"></i> {{ __('settings.boost.buttons.superboost') }}
                                            </button>
                                        @endif
                                        {!! Form::hidden('campaign_id', $userCampaign->id) !!}
                                        {!! Form::close(); !!}
                                    @else
                                        <button class="btn btn-default boost" disabled="disabled">
                                            {{ __('settings.boost.buttons.boost')  }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
            @endif
            <p class="help-block">{!! __('settings.boost.benefits.third', [
                'boost_button' => '<code>' . __('campaigns.show.actions.boost') . '</code>',
                'edit_button' => '<code>' . __('campaigns.show.actions.edit') . '</code>'
            ]) !!}</p>
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
                        {{ __('settings.boost.buttons.unboost') }}
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="more-boosters" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">{{ __('settings.boost.modals.more.title') }}</h4>
                </div>
                <div class="modal-body">
                    <p>{!! __('settings.boost.modals.more.body') !!}</p>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('styles')
    @parent
    <link href="{{ mix('css/settings.css') }}" rel="stylesheet">
@endsection
