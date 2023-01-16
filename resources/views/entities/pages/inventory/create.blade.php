@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/inventories.create.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => __('entities.' . $entity->pluralType())],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        ['url' => route('entities.inventory', $entity->id), 'label' => __('crud.tabs.inventory')],
    ]
])

@section('content')
    {!! Form::open(['route' => ['entities.inventories.store', $entity->id], 'method'=>'POST', 'data-shortcut' => 1, 'data-maintenance' => 1]) !!}
    @include('partials.forms.form', [
            'title' => __('entities/inventories.create.title', ['name' => $entity->name]),
            'content' => 'entities.pages.inventory._form',
            'submit' => __('entities/inventories.actions.add')
        ])
    {!! Form::hidden('entity_id', $entity->id) !!}
    {!! Form::close() !!}
@endsection
