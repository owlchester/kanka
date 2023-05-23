@extends('layouts.app', [
    'title' => __('campaigns.show.tabs.members') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        ['url' => route('campaign'), 'label' => __('entities.campaign')],
        __('campaigns.show.tabs.members')
    ],
    'canonical' => true,
    'mainTitle' => false,
])

@section('content')
    @include('partials.ads.top')
    @include('partials.errors')
    <div class="flex gap-2 flex-col lg:flex-row lg:gap-5">
        <div class="lg:flex-none lg:w-60">
            @include('campaigns._menu', ['active' => 'users'])
        </div>
        <div class="grow max-w-7xl">
            @include('campaigns.members._users')

            @include('campaigns.members._invites')
        </div>
    </div>
@endsection
