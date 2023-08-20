@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => trans('entities/abilities.create.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($entity)->list(),
        Breadcrumb::show(),
        ['url' => route('entities.entity_abilities.index', [$campaign, $entity]), 'label' => trans('crud.tabs.ability')],
    ]
])

@section('content')
    {!! Form::open([
        'route' => ['entities.entity_abilities.store', $campaign, $entity],
        'method'=>'POST',
        'data-shortcut' => 1,
        'class' => 'ajax-subform',
    ]) !!}

    @include('partials.forms.form', [
        'title' => __('entities/abilities.create.title', ['name' => $entity->name]),
        'content' => 'entities.pages.abilities._form',
        'dialog' => true,
    ])

    {!! Form::close() !!}
@endsection
