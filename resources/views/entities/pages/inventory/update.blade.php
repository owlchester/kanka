@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/inventories.update.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($entity)->list(),
        Breadcrumb::show(),
        ['url' => route('entities.inventory', [$campaign, $entity->id]), 'label' => __('crud.tabs.inventory')],
    ]
])

@section('content')
    {!! Form::model($inventory, ['route' => ['entities.inventories.update', $campaign, $entity->id, $inventory], 'method' => 'PATCH', 'data-shortcut' => 1, 'data-maintenance' => 1, 'class' => 'ajax-subform']) !!}

    @include('partials.forms.form', [
        'title' => __('entities/inventories.update.title', ['name' => $entity->name]),
        'content' => 'entities.pages.inventory._form',
        'deleteID' => '#delete-inventory-' . $inventory->id,
        'dialog' => true,
    ])

    <input type="hidden" name="entity_id" value="{{ $entity->id }}" />
    {!! Form::close() !!}

    {!! Form::open(['method' => 'DELETE', 'route' => ['entities.inventories.destroy', 'campaign' => $campaign, 'entity' => $entity, 'inventory' => $inventory], 'id' => 'delete-inventory-' . $inventory->id]) !!}
    {!! Form::close() !!}
@endsection
