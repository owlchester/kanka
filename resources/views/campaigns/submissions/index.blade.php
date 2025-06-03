@php
/** @var \App\Models\Campaign $campaign */
    use \Illuminate\Support\Arr;
@endphp
@extends('layouts.app', [
    'title' => __('campaigns.show.tabs.applications') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        __('campaigns.show.tabs.applications')
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
            <h3 class="inline-block grow">
                {{ __('campaigns.show.tabs.applications') }}
            </h3>
            <x-learn-more url="features/campaigns/applications.html" />
        </div>

        @include('campaigns.submissions._requirements')
        @includeWhen(!$submissions->isEmpty(), 'campaigns.submissions._list')
        @if($submissions->isEmpty())
            <div class="flex flex-col gap-2 justify-center items-center">
                <div class="text-xl">
                    {{ __('campaigns/submissions.helpers.no_applications_title') }}
                </div>
                <div class="text-sm text-neutral-content text-center max-w-md">
                    <p>{!! __('campaigns/submissions.helpers.no_applications', ['button' => '<code><i class="fa-solid fa-door-open" aria-hidden="true"></i> ' . __('dashboard.actions.join') . '</code>']) !!}</p>
                </div>
            </div>
        @endif
    </div>
@endsection


@section('modals')
    <x-dialog id="submission-dialog" loading="true" />
@endsection
