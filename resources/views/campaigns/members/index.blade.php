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
            <h3 class="inline-block grow">
                {{ __('campaigns.show.tabs.members') }} <span class="text-sm">({{ $rows->total() }} / @if ($limit = $campaign->memberLimit()){{ $limit }}@else<i class="fa-solid fa-infinity" aria-hidden="true"></i>@endif)</span>
            </h3>
            <a href="https://docs.kanka.io/en/latest/features/campaigns/members.html" class="btn2 btn-sm btn-ghost" target="_blank">
                <x-icon class="question" />
                {{ __('crud.actions.help') }}
            </a>
        </div>

        @if (!$campaign->canHaveMoreMembers())
            <x-cta :campaign="$campaign" image="0" minimal="1">
                <p>{{ __('campaigns/limits.members') }}</p>
            </x-cta>
        @endif
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
