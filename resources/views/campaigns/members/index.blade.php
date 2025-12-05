@extends('layouts.app', [
    'title' => __('campaigns.show.tabs.members') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        __('campaigns.show.tabs.members')
    ],
    'canonical' => true,
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
                {{ __('campaigns.show.tabs.members') }} <span class="text-sm">({{ $rows->total() }} / @if ($limit = $campaign->memberLimit()){{ $limit }}@else <x-icon class="fa-solid fa-infinity" /> @endif)</span>
            </h1>
            <x-learn-more url="features/campaigns/members.html" />
        </div>

        <x-grid>
            <x-infoBox
                title="{{ __('campaigns/members.overview.title') }}"
                icon="{{ $campaign->boosted() ? 'fa-solid fa-infinity text-green-600' : 'fa-solid fa-warning text-red-500' }}"
                subtitle="{{  __('campaigns/members.overview.' . ($campaign->boosted() ? 'unlimited' : 'limited'), ['total' => $campaign->memberLimit(), 'amount' => $rows->total()]) }}"
                background="{{ $campaign->boosted() ? 'bg-green-200' : 'bg-red-200' }}"
                :campaign="$campaign"
                premium
            ></x-infoBox>
        </x-grid>

        @if(Datagrid::hasBulks())
            <x-form :action="['campaign_roles.bulk', $campaign]" direct>
                <div id="datagrid-parent" class="table-responsive">
                    @include('layouts.datagrid._table')
                </div>
            </x-form>
        @else
            <div id="datagrid-parent" class="table-responsive">
                @include('layouts.datagrid._table')
            </div>
        @endif

        @include('campaigns.members._invites')
    </div>
@endsection
