@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/inventories.create.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($entity)->list(),
        Breadcrumb::show(),
        ['url' => route('entities.inventory', [$campaign, $entity->id]), 'label' => __('crud.tabs.inventory')],
    ]
])

@section('content')
    <x-form :action="['entities.inventories.store', $campaign, $entity->id]">
        @include('partials.forms.form', [
            'title' => __('entities/inventories.create.title', ['name' => $entity->name]),
            'content' => 'entities.pages.inventory._form',
            'submit' => __('entities/inventories.actions.add'),
            'multiple' => true,
        ])
    <input type="hidden" name="entity_id" value="{{ $entity->id }}" />
    </x-form>
@endsection
