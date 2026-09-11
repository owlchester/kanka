@extends('layouts.app', [
    'title' => __('campaigns/import.title') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        __('campaigns.show.tabs.import')
    ],
    'canonical' => true,
    'mainTitle' => false,
    'sidebar' => 'campaign',
    'centered' => true,
])

@section('content')
    <div class="flex gap-5 flex-col">
        @include('ads.top')
        @include('partials.errors')

        <x-campaigns.page-header
            :title="__('campaigns/import.title')"
            learn-more-url="features/campaigns/import.html"
            :lead="__('campaigns/import.description_v2')"
        />

        @can('import', $campaign)
        <livewire:campaigns.csv-import :campaignImport="$import" :campaign="$campaign" />
        @endif
    </div>
@endsection

@section('modals')

@endsection

@section('scripts')
    @parent
    @vite('resources/js/campaigns/import.js')
@endsection
