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

    <div class="flex gap-2 flex-col lg:flex-row lg:gap-5">
        <div class="lg:flex-none lg:w-60">
            @include('campaigns._menu', ['active' => 'campaign'])
        </div>
        <div class="grow max-w-7xl">
            @can('update', $campaign)
                @if($campaign->isPublic() && $campaign->publicHasNoVisibility())
                    <x-alert type="warning">
                        <p>{!! __('campaigns.helpers.public_no_visibility', [
    'fix' => link_to_route('campaigns.campaign_roles.public', __('crud.fix-this-issue'))
]) !!}</p>
                    </x-alert>
                @endif
            @endcan

            @include('campaigns._overview')

            <div class="flex gap-2 mb-2 items-center">
                <h3 class="m-0 inline-block grow">
                    {{ __('campaigns.fields.entry') }}
                </h3>
                @can('update', $campaign)
                    <a href="{{ route('campaigns.edit') }}" class="btn btn-default btn-sm" title="{{ __('campaigns.show.actions.edit') }}">
                        <x-icon class="edit"></x-icon>
                        {{ __('campaigns.show.actions.edit') }}
                    </a>
                @endcan
            </div>
            <x-box>
                @if (auth()->check() && auth()->user()->can('update', $campaign) && empty($campaign->entry()))
                    <a href="{{ route('campaigns.edit') }}">
                        {{ __('campaigns.helpers.no_entry') }}
                    </a>
                @else
                <div class="entity-content">
                    {!! $campaign->entry() !!}
                </div>
                @endif
            </x-box>

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
