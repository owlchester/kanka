@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('maps/groups.create.title', ['name' => $map->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($map->entity)->list(),
        Breadcrumb::show($map),
        ['url' => route('maps.map_groups.index', [$campaign, $map]), 'label' => __('maps.panels.groups')],
        __('maps/groups.create.title')
    ]
])

@section('content')
    <x-dialog.header>
        @if ($campaign->boosted())
            {{ __('maps/groups.pitch.max.limit') }}
        @else
            {!! __('maps/groups.pitch.upgrade.limit', ['limit' => config('limits.campaigns.groups.standard')]) !!}
        @endif
    </x-dialog.header>

    <x-dialog.article class="max-w-3xl">
        @if ($campaign->boosted())
            <x-helper>
                <p>{{ __('maps/groups.pitch.max.helper', ['limit' => $max]) }}</p>
            </x-helper>
        @else
            <x-helper>
                <p>{{ __('maps/groups.pitch.upgrade.upgrade', ['limit' => $max]) }}</p>
            </x-helper>
            <x-premium-cta-footer :campaign="$campaign" />
        @endif
    </x-dialog.article>
@endsection
