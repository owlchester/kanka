@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => trans('entities/abilities.update.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index($entity->pluralType()), 'label' => \App\Facades\Module::plural($entity->typeId(), __('entities.' . $entity->pluralType()))],
        ['url' => $entity->url(), 'label' => $entity->name],
        ['url' => route('entities.entity_abilities.index', $entity->id), 'label' => trans('crud.tabs.abilities')],
    ]
])

@inject('campaignService', 'App\Services\CampaignService')

@section('content')
    {!! Form::model($ability, [
        'route' => ['entities.entity_abilities.update', $entity->id, $ability],
        'method' => 'PATCH',
        'data-shortcut' => 1
    ]) !!}

    @include('partials.forms.form', [
            'title' => __('entities/abilities.update.title', ['name' => $entity->name]),
            'content' => 'entities.pages.abilities._edit_form',
            'deleteID' => '#delete-ability-' . $ability->id,
        ])
    {!! Form::close() !!}

    {!! Form::open(['method' => 'DELETE', 'route' => ['entities.entity_abilities.destroy', 'entity' => $entity, 'entity_ability' => $ability], 'style' => 'display:inline', 'id' => 'delete-ability-' . $ability->id]) !!}
    {!! Form::close() !!}
@endsection
