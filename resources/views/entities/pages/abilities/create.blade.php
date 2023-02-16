@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/abilities.create.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index($entity->pluralType()), 'label' => __('entities.' . $entity->pluralType())],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        ['url' => route('entities.entity_abilities.index', [$campaign, $entity]), 'label' => __('crud.tabs.ability')],
    ]
])

@section('content')
    {!! Form::open([
        'route' => ['entities.entity_abilities.store', [$campaign, $entity]],
        'method'=>'POST',
        'data-shortcut' => 1
    ]) !!}

    @include('partials.forms.form', [
        'title' => __('entities/abilities.create.title', ['name' => $entity->name]),
        'content' => 'entities.pages.abilities._form',
    ])

    {!! Form::close() !!}
@endsection
