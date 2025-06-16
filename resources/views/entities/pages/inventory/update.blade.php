@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/inventories.update.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($entity)->list(),
        Breadcrumb::show(),
        ['url' => route('entities.inventory', [$campaign, $entity->id]), 'label' => __('crud.tabs.inventory')],
    ]
])

@section('content')
    <x-form method="PATCH" :action="['entities.inventories.update', $campaign, $entity->id, $inventory]">
    @include('partials.forms._dialog', [
        'title' => __('entities/inventories.update.title', ['name' => $entity->name]),
        'content' => 'entities.pages.inventory._form',
        'deleteID' => '#delete-inventory-' . $inventory->id,
    ])

    <input type="hidden" name="entity_id" value="{{ $entity->id }}" />
    </x-form>

    <x-form method="DELETE" :action="['entities.inventories.destroy', $campaign, 'entity' => $entity, 'inventory' => $inventory]" id="delete-inventory-{{ $inventory->id }}" />
@endsection
