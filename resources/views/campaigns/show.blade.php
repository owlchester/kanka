<?php /** @var \App\Models\Campaign $campaign */?>
@extends('layouts.app', [
    'title' => __('campaigns.show.title', ['name' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => __('entities.campaign')]
    ],
    'canonical' => true,
    'mainTitle' => false,
])

@section('og')
    <meta property="og:description" content="{{ $campaign->preview() }}" />
    @if ($campaign->image)<meta property="og:image" content="{{ Img::crop(280, 280)->url($campaign->image)  }}" />
    <meta property="og:image:width" content="280" />
    <meta property="og:image:height" content="280" />@endif
    <meta property="og:url" content="{{ route('campaigns.show', $campaign)  }}" />
@endsection

@section('content')
    @include('partials.errors')
    @include('partials.ads.top')

    <div class="row">
        <div class="col-md-3">
            @include('campaigns._menu', ['active' => 'campaign'])
        </div>
        <div class="col-md-9">
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ __('campaigns.show.menus.overview') }}</h3>
                </div>
                <div class="box-body">
                    @can('update', $campaign)
                        @if($campaign->isPublic() && $campaign->publicHasNoVisibility())
                            <div class="alert alert-warning">
                                <p>{!! __('campaigns.helpers.public_no_visibility', [
    'fix' => link_to_route('campaigns.campaign_roles.public', __('crud.fix-this-issue'))
]) !!}</p>
                            </div>
                        @endif
                    @endcan
                    <div class="row">
                        <div class="col-sm-6">
                            <dl class="dl-horizontal dl-force-mobile">
                                <dt>{{ __('campaigns.fields.visibility') }}</dt>
                                <dd>
                                    @if ($campaign->isPublic())
                                        {{ __('campaigns.visibilities.public') }}
                                    @else
                                        {{ __('campaigns.visibilities.private') }}
                                    @endif
                                    @can ('update', $campaign)
                                        <a href="#" role="button" class="ml-2" data-url="{{ route('campaign-visibility', ['from' => 'overview']) }}" data-target="#entity-modal" data-toggle="ajax-modal">
                                            <i class="fa-solid fa-pencil" aria-hidden="true"></i>
                                            {{ __('crud.actions.change') }}
                                        </a>
                                    @endcan
                                </dd>

                                <dt>
                                    {{ __('campaigns.fields.entity_count') }}
                                </dt>
                                <dd>
                                    {{ number_format(\App\Facades\CampaignCache::entityCount()) }}
                                    <i class="fa-solid fa-question-circle" data-toggle="tooltip" title="{{ __('campaigns.helpers.entity_count_v2') }}"></i>
                                </dd>

                                @if ($campaign->isPublic())
                                <dt>{{ __('campaigns.fields.followers') }}</dt>
                                <dd>{{ number_format($campaign->follower()) }}</dd>
                                @endif
                            </dl>
                        </div>
                        <div class="col-sm-6">
                            <dl class="dl-horizontal dl-force-mobile">
                                @if ($campaign->boosted() && $campaign->boosts->count() > 0)
                                    <dt class="text-maroon">
                                        <i class="fa-solid fa-rocket"></i> {{ __('campaigns.fields.' . ($campaign->superboosted() ? 'superboosted' : 'boosted')) }}
                                    </dt>
                                    <dd>
                                        {{ $campaign->boosts->first()->user->name }}
                                    </dd>
                                @endif

                                @if ($campaign->locale)
                                    <dt>{{ __('campaigns.fields.locale') }}</dt>
                                    <dd>{{ __('languages.codes.' . $campaign->locale) }}</dd>
                                @endif

                                @if (!empty($campaign->system))
                                    <dt>{{ __('campaigns.fields.system') }}</dt>
                                    <dd>{{ $campaign->system }}</dd>
                                @endif
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        {{ __('campaigns.fields.entry') }}
                    </h3>
                    <div class="box-tools pull-right">
                        @can('update', $campaign)
                            <a href="{{ route('campaigns.edit', $campaign->id) }}" class="btn btn-box-tool" title="{{ __('campaigns.show.actions.edit') }}">
                                <i class="fa-solid fa-edit" aria-hidden="true"></i>
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="box-body">
                    <p>{!! $campaign->entry() !!}</p>
                </div>
            </div>

            <div class="entity-modification-history">
                <div class="help-block text-right">
                    @if (!empty($campaign->created_at) && !empty($campaign->updated_at))
                    {!! __('crud.history.created_date_clean', [
                        'date' => '<span data-toggle="tooltip" title="' . $campaign->created_at . ' UTC' . '">' . $campaign->created_at->diffForHumans() . '</span>'
                    ]) !!}. {!! __('crud.history.updated_date_clean', [
                        'date' => '<span data-toggle="tooltip" title="' . $campaign->updated_at . ' UTC' . '">' . $campaign->updated_at->diffForHumans() . '</span>'
                    ]) !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
