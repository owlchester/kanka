@php
/** @var \App\Models\Campaign $campaign */
    use \Illuminate\Support\Arr;
@endphp
@extends('layouts.app', [
    'title' => __('campaigns.show.tabs.logs') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        __('campaigns.show.tabs.logs')
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
                {{ __('campaigns.show.tabs.logs') }}
            </h3>
            <a class="btn2 btn-sm btn-ghost" href="https://docs.kanka.io/campaign-logs.html">
                <x-icon class="question" />
                {{ __('crud.actions.help') }}
            </a>
        </div>

        @includeWhen(!$logs->isEmpty(), 'campaigns.logs._list')
        @if($logs->isEmpty())
            <div class="flex flex-col gap-2 justify-center items-center">
                <div class="text-xl">
                    {{ __('campaigns/logs.helpers.title') }}
                </div>
                <div class="text-sm text-neutral-content text-center max-w-md">
                    <p>{!! __('campaigns/logs.helpers.nothing', ['amount' => '<code>' . config('limits.campaigns.logs') . '</code>']) !!}</p>
                </div>
            </div>
        @endif
    </div>
@endsection


@section('modals')

    @include('partials.helper-modal', [
        'id' => 'submissions-help',
        'title' => __('campaigns.show.tabs.applications'),
        'textes' => [
            __('campaigns/submissions.helpers.modal')
    ]])

    <x-dialog id="submission-dialog" loading="true" />
@endsection
