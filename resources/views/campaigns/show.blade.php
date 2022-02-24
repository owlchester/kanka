@extends('layouts.app', [
    'title' => __('campaigns.show.title', ['name' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => __('campaigns.index.title')]
    ],
    'canonical' => true,
    'mainTitle' => false,
])

@section('og')
    <meta property="og:description" content="{{ $campaign->tooltip() }}" />
    @if ($campaign->image)<meta property="og:image" content="{{ Img::crop(50, 50)->url($campaign->image)  }}" />@endif

    <meta property="og:url" content="{{ route('campaigns.show', $campaign)  }}" />
@endsection

@section('content')
    @include('partials.errors')
    <div class="row">
        <div class="{{ auth()->check() ? "col-md-3" : "" }}">
            @include('campaigns._menu', ['active' => 'campaign'])
        </div>
        <div class="{{ auth()->check() ? "col-md-9" : "col-md-12" }}">
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
                                <dd>{{ __('campaigns.visibilities.' . ($campaign->isPublic() ? 'public' : 'private')) }}</dd>

                                <dt>
                                    {{ __('campaigns.fields.entity_count') }}
                                </dt>
                                <dd>
                                    {{ number_format(\App\Facades\CampaignCache::entityCount()) }}
                                    <i class="fas fa-question-circle" data-toggle="tooltip" title="{{ __('campaigns.helpers.entity_count') }}"></i>
                                </dd>

                                @if ($campaign->isPublic())
                                <dt>{{ __('campaigns.fields.followers') }}</dt>
                                <dd>{{ \App\Facades\CampaignCache::followerCount() }}</dd>
                                @endif
                            </dl>
                        </div>
                        <div class="col-sm-6">
                            <dl class="dl-horizontal dl-force-mobile">
                                @if ($campaign->boosted() && $campaign->boosts->count() > 0)
                                    <dt class="text-maroon">
                                        <i class="fa fa-rocket"></i> {{ __('campaigns.fields.' . ($campaign->boosts->count() >= 3 ? 'superboosted' : 'boosted')) }}
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
                                <i class="fa fa-edit" aria-hidden="true"></i>
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
