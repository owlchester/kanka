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
    @if($campaign->isOpen() && !$campaign->flags->contains('flag', \App\Enums\CampaignFlags::CanOpen->value))
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
            
            @if (!isset($filter) || $filter !== 'all')
                <a class="btn2 btn-default btn-sm btn-view-as" 
                href="{{ route('applications.index', ['campaign' => $campaign, 'filter' => 'all']) }}" 
                data-title="{{ __('campaigns/applications.filters.all') }}" 
                data-toggle="tooltip">
                    <i class="fa-regular fa-filter-slash" aria-hidden="true"></i>    
                    {{ __('campaigns/applications.filters.all') }}
                </a>
            @endif
            @if (isset($filter))
                <a class="btn2 btn-default btn-sm btn-view-as {{ $filter === 'pending' ? 'active btn-primary' : '' }}" 
                href="{{ route('applications.index', ['campaign' => $campaign]) }}" 
                data-title="{{ __('campaigns/applications.filters.pending') }}" 
                data-toggle="tooltip">
                    <i class="fa-regular fa-clock" aria-hidden="true"></i>    
                    {{ __('campaigns/applications.filters.pending') }}
                </a>
            @endif
            @if (!isset($filter) || $filter !== 'approved')
                <a class="btn2 btn-default btn-sm btn-view-as {{ $filter === 'approved' ? 'active btn-primary' : '' }}" 
                href="{{ route('applications.index', ['campaign' => $campaign, 'filter' => 'approved']) }}" 
                data-title="{{ __('campaigns/applications.filters.approved') }}" 
                data-toggle="tooltip">
                    <i class="fa-regular fa-check " aria-hidden="true"></i>    
                    {{ __('campaigns/applications.filters.approved') }}
                </a>
            @endif
            @if (!isset($filter) || $filter !== 'rejected')
                <a class="btn2 btn-default btn-sm btn-view-as {{ $filter === 'rejected' ? 'active btn-primary' : '' }}" 
                href="{{ route('applications.index', ['campaign' => $campaign, 'filter' => 'rejected']) }}" 
                data-title="{{ __('campaigns/applications.filters.rejected') }}" 
                data-toggle="tooltip">
                    <i class="fa-regular fa-xmark " aria-hidden="true"></i>    
                    {{ __('campaigns/applications.filters.rejected') }}
                </a>
            @endif
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
