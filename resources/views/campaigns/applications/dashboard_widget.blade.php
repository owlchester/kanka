<?php /** @var \App\Models\Campaign $campaign */ ?>
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

    <div class="flex gap-2 items-center justify-between">
        <h1 class="text-2xl">
            {{ __('campaigns/applications.dashboard_widget.title') }}
        </h1>
    </div>

    @include('partials.errors')

    <x-box class="flex flex-col gap-6 mt-4">
        @if ($hasJoinWidget)
            <div class="flex items-center gap-4">
                <div class="rounded bg-green-200 w-12 h-12 flex items-center justify-center flex-none">
                    <x-icon class="fa-solid fa-check text-green-600" />
                </div>
                <div class="flex flex-col gap-1">
                    <span class="font-medium">{{ __('campaigns/applications.dashboard_widget.has_widget') }}</span>
                    <span class="text-sm text-base-content/70">{{ __('campaigns/applications.dashboard_widget.has_widget_help') }}</span>
                </div>
            </div>
        @else
            <div class="flex items-center gap-4">
                <div class="rounded bg-red-200 w-12 h-12 flex items-center justify-center flex-none">
                    <x-icon class="fa-solid fa-times text-red-600" />
                </div>
                <div class="flex flex-col gap-1">
                    <span class="font-medium">{{ __('campaigns/applications.dashboard_widget.no_widget') }}</span>
                    <span class="text-sm text-base-content/70">{{ __('campaigns/applications.dashboard_widget.no_widget_help') }}</span>
                </div>
            </div>

            <x-form method="POST" :action="['campaign-applications.dashboard-widget.store', $campaign]">
                <button type="submit" class="btn2 btn-primary">
                    <x-icon class="fa-solid fa-plus" />
                    {{ __('campaigns/applications.dashboard_widget.add') }}
                </button>
            </x-form>
        @endif
    </x-box>
@endsection
