@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => trans('entities/abilities.update.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($entity)->list(),
        Breadcrumb::show(),
        ['url' => route('entities.entity_abilities.index', [$campaign, $entity]), 'label' => __('entities.ability')],
    ],
    'centered' => true,
])


@section('content')
    <x-form :action="['entities.entity_abilities.update', $campaign, $entity->id, $ability]" method="PATCH">
        @include('partials.forms._dialog', [
            'title' => __('entities/abilities.update.title', ['name' => $entity->name]),
            'content' => 'entities.pages.abilities._edit_form',
            'deleteID' => '#delete-ability-' . $ability->id,
        ])
    </x-form>

    <x-form method="DELETE" :action="['entities.entity_abilities.destroy', $campaign, 'entity' => $entity, 'entity_ability' => $ability]" id="delete-ability-{{ $ability->id }}" />
@endsection
