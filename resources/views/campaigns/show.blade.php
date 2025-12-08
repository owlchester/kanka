<?php /** @var \App\Models\Campaign $campaign */?>
@extends('layouts.app', [
    'title' => __('campaigns.show.title', ['name' => $campaign->name]),
    'breadcrumbs' => false,
    'canonical' => true,
    'mainTitle' => false,
    'sidebar' => 'campaign',
    'centered' => true,
])

@section('og')
    <meta property="og:description" content="{{ $campaign->preview() }}" />
    @if ($campaign->image)<meta property="og:image" content="{{ Img::crop(280, 280)->url($campaign->image)  }}" />
    <meta property="og:image:width" content="280" />
    <meta property="og:image:height" content="280" />@endif
    <meta property="og:url" content="{{ route('overview', $campaign)  }}" />
@endsection

@section('content')
    @include('partials.errors')
    @include('ads.top')

    <div class="flex gap-5 flex-col">
        <div class="flex gap-2 items-center justify-between">
            <h1 class="inline-block text-2xl">
                {!! $campaign->name !!}
            </h1>

            <div class="join">
                @can('update', $campaign)
                    <a href="{{ route('campaigns.edit', $campaign) }}" class="btn2 join-item" title="{{ __('campaigns.show.actions.edit') }}">
                        <x-icon class="edit" />
                        {{ __('campaigns.show.actions.edit') }}
                    </a>
                @endcan
                @can('member', $campaign)
                    <div class="dropdown">
                        <button type="button" class="btn2 join-item" data-dropdown
                                aria-expanded="false">
                            <x-icon class="fa-regular fa-bars" />
                            <span class="sr-only">{{ __('crud.actions.actions') }}</span>
                        </button>
                        <div class="dropdown-menu hidden" role="menu">
                            <x-dropdowns.item
                                link="#"
                                :dialog="route('campaign.leave', $campaign)"
                                icon="fa-regular fa-person-walking text-neutral-content">
                                {{ __('campaigns.leave.action') }}
                            </x-dropdowns.item>
                        </div>
                    </div>
                @endcan
            </div>
        </div>

        @include('campaigns._overview')

        @can('update', $campaign)
            @if($campaign->isPublic() && $campaign->publicHasNoVisibility())
                <x-alert type="warning">
                    <p>{!! __('campaigns.helpers.public_no_visibility', [
'fix' => '<a href="' . route('campaigns.campaign_roles.public', $campaign) . '">' . __('crud.fix-this-issue') . '</a>'
]) !!}</p>
                </x-alert>
            @endif
        @endcan

        <div class="flex flex-col gap-2">
            <x-box class="rounded-xl">
                @if (auth()->check() && auth()->user()->can('update', $campaign) && empty($campaign->entry))
                    <a href="{{ route('campaigns.edit', $campaign) }}">
                        {{ __('campaigns.helpers.no_entry') }}
                    </a>
                @else
                <div class="entity-content">
                    {!! $campaign->parsedEntry() !!}
                </div>
                @endif
            </x-box>

            <div class="entity-modification-history">
                <div class="help-block text-right italic text-xs">
                    @if (!empty($campaign->created_at) && !empty($campaign->updated_at))
                    {!! __('crud.history.created_date_clean', [
                        'date' => '<span data-toggle="tooltip" data-title="' . $campaign->created_at . ' UTC' . '">' . $campaign->created_at->diffForHumans() . '</span>'
                    ]) !!}. {!! __('crud.history.updated_date_clean', [
                        'date' => '<span data-toggle="tooltip" data-title="' . $campaign->updated_at . ' UTC' . '">' . $campaign->updated_at->diffForHumans() . '</span>'
                    ]) !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection


@section('modals')
    @parent

    <x-dialog id="leave-confirm" :loading="true" />


@endsection
