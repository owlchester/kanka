@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/inventories.update.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => __('entities.' . $entity->pluralType())],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        ['url' => route('entities.inventory', [$campaign, $entity]), 'label' => __('crud.tabs.inventory')],
    ]
])

@section('content')
    {!! Form::model($inventory, ['route' => ['entities.inventories.update', [$campaign, $entity, $inventory]], 'method' => 'PATCH', 'data-shortcut' => 1, 'data-maintenance' => 1]) !!}

    @include('partials.forms.form', [
        'title' => __('entities/inventories.update.title', ['name' => $entity->name]),
        'content' => 'entities.pages.inventory._form',
    ])

    {!! Form::hidden('entity_id', $entity->id) !!}
    {!! Form::close() !!}
@endsection
