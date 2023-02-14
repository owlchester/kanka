<?php /** @var \App\Models\Campaign $campaign */?>
@extends('layouts.app', [
    'title' => __('campaigns.show.title', ['name' => $campaign->name]),
    'breadcrumbs' => [
        ['url' => route('overview', $campaign), 'label' => __('entities.campaign')]
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
            @can('update', $campaign)
                @if($campaign->isPublic() && $campaign->publicHasNoVisibility())
                    <div class="alert alert-warning">
                        <p>{!! __('campaigns.helpers.public_no_visibility', [
    'fix' => link_to_route('campaign_roles.public', __('crud.fix-this-issue'))
]) !!}</p>
                    </div>
                @endif
            @endcan

            @include('campaigns._overview')

            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        {{ __('campaigns.fields.entry') }}
                    </h3>
                    <div class="box-tools pull-right">
                        @can('update', $campaign)
                            <a href="{{ route('edit', $campaign) }}" class="btn btn-box-tool" title="{{ __('campaigns.show.actions.edit') }}">
                                <i class="fa-solid fa-edit" aria-hidden="true"></i>
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="box-body">
                    @if (auth()->check() && auth()->user()->can('update', $campaign) && empty($campaign->entry()))
                        <a href="{{ route('edit', $campaign) }}">
                            {{ __('campaigns.helpers.no_entry') }}
                        </a>
                    @else
                    <p>{!! $campaign->entry() !!}</p>
                    @endif
                </div>
            </div>

            <div class="entity-modification-history">
                <div class="help-block text-right italic text-xs">
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
