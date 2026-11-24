@extends('layouts.app', [
    'title' => __('campaigns/recovery.title') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        __('campaigns.show.tabs.recovery')
    ],
    'mainTitle' => false,
    'sidebar' => 'campaign',
    'centered' => true,
])

@section('content')
    <div class="flex gap-5 flex-col">
        @include('partials.errors')
        <x-campaigns.page-header
            :title="__('campaigns/recovery.title')"
            learn-more-url="features/campaigns/recovery.html"
            :lead="__('campaigns/recovery.tutorial', ['amount' => '<span class=font-extrabold>' . config('entities.hard_delete') . '</span>'])"
        />
        @if (!$campaign->boosted())
            <x-premium-cta-alert :campaign="$campaign" source="recovery">
                <x-slot name="title">
                    {!! __('campaigns/recovery.cta.title') !!}
                </x-slot>
                <x-slot name="lead">
                    {!! __('campaigns/recovery.cta.lead') !!}
                </x-slot>
            </x-premium-cta-alert>
        @endif
        <div id="recovery" data-api="{{ route('recovery.setup', [$campaign]) }}"></div>
    </div>

@endsection

@section('scripts')
    @parent
    @vite('resources/js/recovery/recovery.js')
@endsection
