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

    <div class="flex gap-5 flex-col">
        <div class="flex gap-2 items-center">
            <h1 class="inline-block grow text-2xl">
                {{ __('campaigns/applications.title') }}
            </h1>
            <x-learn-more url="features/campaigns/applications.html" />
        </div>

        <p>{!! __('campaigns/applications.tutorial') !!}</p>

        @include('campaigns.applications._requirements')
        @includeWhen(!$applications->isEmpty(), 'campaigns.applications._list')
        @if($applications->isEmpty())
            <div class="flex flex-col gap-2 justify-center items-center">
                <div class="text-xl">
                    {{ __('campaigns/applications.helpers.no_applications_title') }}
                </div>
                <div class="text-sm text-neutral-content text-center max-w-md">
                    <p>{!! __('campaigns/applications.helpers.no_applications', ['button' => '<code><i class="fa-solid fa-door-open" aria-hidden="true"></i> ' . __('dashboard.actions.join') . '</code>']) !!}</p>
                </div>
            </div>
        @endif
    </div>
@endsection


@section('modals')
    <x-dialog id="application-dialog" loading="true" />
@endsection
