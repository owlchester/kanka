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
    <x-form :action="['entities.inventory.copy.store', $campaign, $entity->id]" class="ajax-subform">
    @include('partials.forms.form', [
            'title' => __('entities/inventories.copy.title', ['name' => $entity->name]),
            'content' => 'entities.pages.inventory._copy',
            'submit' => __('entities/inventories.actions.copy_inventory'),
            'dialog' => true,
        ])
    </x-form>
@endsection
