@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/abilities.update.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index($entity->pluralType()), 'label' => __('entities.' . $entity->pluralType())],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        ['url' => route('entities.entity_abilities.index', [$campaign, $entity]), 'label' => __('crud.tabs.abilities')],
    ]
])

@section('content')
    {!! Form::model($ability, [
        'route' => ['entities.entity_abilities.update', [$campaign, $entity, $ability]],
        'method' => 'PATCH',
        'data-shortcut' => 1
    ]) !!}

    @include('partials.forms.form', [
            'title' => __('entities/abilities.update.title', ['name' => $entity->name]),
            'content' => 'entities.pages.abilities._edit_form',
            'deleteID' => '#delete-ability-' . $ability->id,
        ])
    {!! Form::close() !!}

    {!! Form::open(['method' => 'DELETE', 'route' => ['entities.entity_abilities.destroy', [$campaign, $entity, $ability]], 'style' => 'display:inline', 'id' => 'delete-ability-' . $ability->id]) !!}
    {!! Form::close() !!}
@endsection
