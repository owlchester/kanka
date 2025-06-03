@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('maps/layers.create.title', ['name' => $map->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($map->entity)->list(),
        Breadcrumb::show($map),
        ['url' => route('maps.map_layers.index', [$campaign, $map]), 'label' => __('maps.panels.layers')],
        __('maps/layers.create.title')
    ]
])

@section('content')

    @if ($campaign->boosted())
        <x-box class="rounded-xl flex flex-col gap-4 p-6">
            <h2 class="text-2xl">
                <x-icon class="fa-regular fa-exclamation-triangle" />
                {{ __('maps/groups.pitch.max.limit') }}
            </h2>
            <x-helper>
                <p>{{ __('maps/layers.pitch.max.helper', ['limit' => $max]) }}</p>
            </x-helper>
        </x-box>
    @else
        <x-premium-cta :campaign="$campaign">
            <p>{{ __('maps/layers.pitch.upgrade.upgrade', ['limit' => $max]) }}</p>
        </x-premium-cta>
    @endif

@endsection
