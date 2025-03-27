@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/abilities.create.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($entity)->list(),
        Breadcrumb::show(),
        ['url' => route('entities.entity_abilities.index', [$campaign, $entity]), 'label' => __('entities.ability')],
    ],
    'centered' => true,
])

@section('content')
    <x-form :action="['entities.entity_abilities.store', $campaign, $entity]">

    @include('partials.forms._dialog', [
        'title' => __('entities/abilities.create.title', ['name' => $entity->name]),
        'content' => 'entities.pages.abilities._form',
    ])

    </x-form>
@endsection
