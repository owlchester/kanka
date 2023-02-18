@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('maps/layers.create.title', ['name' => $map->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route('maps.index', $campaign->id), 'label' => __('entities.maps')],
        ['url' => $map->entity->url('show'), 'label' => $map->name],
        ['url' => route('maps.map_layers.index', [$campaign->id, $map->id]), 'label' => __('maps.panels.layers')],
        __('maps/layers.create.title')
    ]
])

@section('content')
<div class="modal-body text-center">
    @if (request()->ajax())
    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
    @endif

    @if ($campaign->boosted())
        {{ __('maps/layers.pitch.error') }}
    @else
        @include('layouts.callouts.boost-modal', ['texts' => [__('maps/layers.pitch.until', ['max' => $max])]])
    @endif
</div>

@endsection
