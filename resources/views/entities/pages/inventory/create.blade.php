@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/inventories.create.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($entity)->list(),
        Breadcrumb::show(),
        ['url' => route('entities.inventory', [$campaign, $entity->id]), 'label' => __('crud.tabs.inventory')],
    ]
])

@section('content')
    {!! Form::open(['route' => ['entities.inventories.store', $campaign, $entity->id], 'method'=>'POST', 'data-shortcut' => 1, 'data-maintenance' => 1, 'class' => 'ajax-subform']) !!}
    @include('partials.forms.form', [
            'title' => __('entities/inventories.create.title', ['name' => $entity->name]),
            'content' => 'entities.pages.inventory._form',
            'submit' => __('entities/inventories.actions.add'),
            'dialog' => true,
            'multiple' => true,
        ])
    <input type="hidden" name="entity_id" value="{{ $entity->id }}" />
    {!! Form::close() !!}
@endsection
