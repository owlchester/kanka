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

        <div class="flex gap-2 items-center justify-between">
            <h1 class="text-2xl">
                {{ __('campaigns/import.title') }}
            </h1>
            <x-learn-more url="features/campaigns/import.html" />
        </div>

        <p class="max-w-2xl">{{ __('campaigns/import.description_v2') }}</p>

        @can('import', $campaign)
            @livewire('campaigns.csv-import', ['campaignImport' => $import, 'campaign' => $campaign])
        @endif
    </div>
@endsection

@section('modals')

@endsection

@section('scripts')
    @parent
    @vite('resources/js/campaigns/import.js')
@endsection
