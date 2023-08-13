@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => trans('entities/abilities.update.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($entity)->list(),
        Breadcrumb::show(),
        ['url' => route('entities.entity_abilities.index', [$campaign, $entity]), 'label' => trans('crud.tabs.abilities')],
    ]
])


@section('content')
    {!! Form::model($ability, [
        'route' => ['entities.entity_abilities.update', $campaign, $entity->id, $ability],
        'method' => 'PATCH',
        'data-shortcut' => 1
    ]) !!}

    @include('partials.forms.form', [
            'title' => __('entities/abilities.update.title', ['name' => $entity->name]),
            'content' => 'entities.pages.abilities._edit_form',
            'deleteID' => '#delete-ability-' . $ability->id,
        ])
    {!! Form::close() !!}

    {!! Form::open(['method' => 'DELETE', 'route' => ['entities.entity_abilities.destroy', $campaign, 'entity' => $entity, 'entity_ability' => $ability], 'style' => 'display:inline', 'id' => 'delete-ability-' . $ability->id]) !!}
    {!! Form::close() !!}
@endsection
