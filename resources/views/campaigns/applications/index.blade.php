@php
/** @var \App\Models\Campaign $campaign */
    use \Illuminate\Support\Arr;
@endphp
@extends('layouts.app', [
    'title' => __('campaigns/applications.title') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        __('campaigns/applications.title')
    ],
    'mainTitle' => false,
    'sidebar' => 'campaign',
    'centered' => true,
])

@section('content')
    @include('ads.top')
    @include('partials.errors')
    @if(!$campaign->isOpen() && $campaign->isPublic())
        <x-alert type="info" :dismissible="true">
            <strong>{{ __('campaigns/applications.warnings.applications_closed') }}</strong><br/>
            <p>{{ __('campaigns/applications.helpers.applications_closed') }}</p>
        </x-alert>
    @endif
    @if($campaign->isOpen() && auth()->user()->cannot('canOpen', $campaign))
        <x-alert type="info" :dismissible="true">
            <strong>{{ __('campaigns/applications.warnings.filters_incomplete') }}</strong><br/>
            <p>{{ __('campaigns/applications.helpers.filters_incomplete') }}</p>
        </x-alert>
    @endif
    <div class="flex gap-5 flex-col">
        <div class="flex gap-2 items-center justify-between">
            <h1 class="text-2xl">
                {{ __('campaigns/applications.title') }}
            </h1>
            <x-learn-more url="features/campaigns/applications.html" />
        </div>

        <p>{!! __('campaigns/applications.tutorial') !!}</p>

        @include('campaigns.applications._requirements')

        <div class="flex gap-2 items-center justify-end">
            <div class="dropdown">
                <button type="button" class="btn2 btn-default btn-sm" data-dropdown aria-expanded="false">
                    <i class="fa-regular fa-filter" aria-hidden="true"></i>
                    {{ __('campaigns/applications.filters.title') }}
                </button>
                <div class="dropdown-menu hidden" role="menu">
                    <x-dropdowns.item
                        :link="route('applications.index', ['campaign' => $campaign])"
                        icon="fa-regular fa-clock"
                        :css="!isset($filter) ? 'font-semibold' : ''">
                        {{ __('campaigns/applications.filters.pending') }}
                    </x-dropdowns.item>
                    <x-dropdowns.item
                        :link="route('applications.index', ['campaign' => $campaign, 'filter' => 'approved'])"
                        icon="fa-regular fa-check"
                        :css="($filter ?? '') === 'approved' ? 'font-semibold' : ''">
                        {{ __('campaigns/applications.filters.approved') }}
                    </x-dropdowns.item>
                    <x-dropdowns.item
                        :link="route('applications.index', ['campaign' => $campaign, 'filter' => 'rejected'])"
                        icon="fa-regular fa-xmark"
                        :css="($filter ?? '') === 'rejected' ? 'font-semibold' : ''">
                        {{ __('campaigns/applications.filters.rejected') }}
                    </x-dropdowns.item>
                    <x-dropdowns.divider />
                    <x-dropdowns.item
                        :link="route('applications.index', ['campaign' => $campaign, 'filter' => 'all'])"
                        icon="fa-regular fa-filter-slash"
                        :css="($filter ?? '') === 'all' ? 'font-semibold' : ''">
                        {{ __('campaigns/applications.filters.all') }}
                    </x-dropdowns.item>
                </div>
            </div>
        </div>

        @includeWhen(!$applications->isEmpty(), 'campaigns.applications._list')
        @if($applications->isEmpty())
            <div class="flex flex-col gap-2 justify-center items-center">
                <div class="text-xl">
                    {{ __('campaigns/applications.helpers.no_applications_title') }}
                </div>
                <div class="text-sm text-neutral-content text-center max-w-md">
                    <p>{!! __('campaigns/applications.helpers.no_applications_v2') !!}</p>
                </div>
            </div>
        @endif
    </div>
@endsection


@section('modals')
    <x-dialog id="application-dialog" loading="true" />
@endsection
