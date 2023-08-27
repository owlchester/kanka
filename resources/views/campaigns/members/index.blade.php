@extends('layouts.app', [
    'title' => __('campaigns.show.tabs.members') . ' - ' . $campaign->name,
    'breadcrumbs' => [
        ['url' => route('overview', $campaign), 'label' => __('entities.campaign')],
        __('campaigns.show.tabs.members')
    ],
    'canonical' => true,
    'mainTitle' => false,
    'sidebar' => 'campaign',
])

@section('content')
    @include('partials.ads.top')
    @include('partials.errors')
    <div class="flex gap-5 flex-col max-w-7xl">
        <div class="flex gap-2 items-center">
            <h3 class="m-0 inline-block grow">
                {{ __('campaigns.show.tabs.members') }} <span class="text-sm">({{ $rows->total() }} / @if ($limit = $campaign->memberLimit()){{ $limit }}@else<i class="fa-solid fa-infinity" aria-hidden="true"></i>@endif)</span>
            </h3>
            <a href="https://docs.kanka.io/en/latest/features/campaigns/members.html" class="btn2 btn-sm btn-ghost" target="_blank">
                <x-icon class="question"></x-icon>
                {{ __('crud.actions.help') }}
            </a>
        </div>

        @if (!$campaign->canHaveMoreMembers())
            <x-cta :campaign="$campaign" image="0" minimal="1">
                <p>{{ __('campaigns/limits.members') }}</p>
            </x-cta>
        @endif
        @if(Datagrid::hasBulks()) {!! Form::open(['route' => ['campaign_roles.bulk', $campaign]]) !!} @endif
            <div id="datagrid-parent">
                @include('layouts.datagrid._table', ['responsive' => true])
            </div>
        @if(Datagrid::hasBulks()) {!! Form::close() !!} @endif

        @include('campaigns.members._invites')
    </div>
@endsection
