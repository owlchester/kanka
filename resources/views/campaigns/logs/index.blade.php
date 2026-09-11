@php
/** @var \App\Models\Campaign $campaign */
    use \Illuminate\Support\Arr;
@endphp
@extends('layouts.app', [
    'title' => __('campaigns/logs.title') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        __('campaigns/logs.title')
    ],
    'mainTitle' => false,
    'sidebar' => 'campaign',
    'centered' => true,
])

@section('content')
    @include('ads.top')
    @include('partials.errors')

    <div class="flex gap-5 flex-col">
        <x-campaigns.page-header
            :title="__('campaigns/logs.title')"
            learn-more-url="features/campaigns/logs"
            :lead="__('campaigns/logs.helpers.list', ['amount' => '<code>' . $premium . '</code>'])"
        />

        @if (!$campaign->premium())
            <x-premium-cta-alert :campaign="$campaign" source="audit-log">
                <x-slot name="title">
                    {!! __('campaigns/logs.cta.title') !!}
                </x-slot>
                <x-slot name="lead">
                    {!! __('campaigns/logs.cta.lead', ['amount' => '<code>' . $premium . '</code>']) !!}
                </x-slot>
            </x-premium-cta-alert>
        @endif

        @includeWhen(!$logs->isEmpty(), 'campaigns.logs._list')
        @if($logs->isEmpty())
            <x-box class="border-dashed border-neutral-content border">
                <div class="mx-auto max-w-2xl lg:p-4 flex flex-col items-center gap-2 text-center">
                    <div class="font-bold text-lg">
                        {{ __('campaigns/logs.helpers.title') }}
                    </div>
                    <p class="text-neutral-content mb-2">
                        {{ __('campaigns/logs.helpers.empty') }}
                    </p>
                </div>
            </x-box>
        @endif

        <p class="text-neutral-content">
            {!! __('campaigns/logs.helpers.history', ['amount' => '<code>' . $cutoff . '</code>']) !!}
        </p>
    </div>
@endsection
