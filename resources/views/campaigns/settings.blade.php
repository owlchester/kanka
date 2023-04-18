@extends('layouts.app', [
    'title' => __('campaigns.show.tabs.settings') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => __('entities.campaign')],
        __('campaigns.show.tabs.settings')
    ],
    'canonical' => true,
    'mainTitle' => false,
])

@section('content')
    @include('partials.errors')
    <div class="flex gap-2 flex-col lg:flex-row lg:gap-5">
        <div class="lg:flex-none lg:w-60">
            @include('campaigns._menu', ['active' => 'settings'])
        </div>
        <div class="grow campaign-settings">
            @include('campaigns.settings.index')
        </div>
    </div>
@endsection
