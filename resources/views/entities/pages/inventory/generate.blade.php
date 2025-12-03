@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/inventories.generate.title'),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($entity)->list(),
        Breadcrumb::show(),
        ['url' => route('entities.inventory', [$campaign, $entity->id]), 'label' => __('crud.tabs.inventory')],
    ]
])

@section('content')
    <x-form :action="['entities.inventory.generate.store', $campaign, $entity->id]">
    @include('partials.forms.form', [
            'title' => __('entities/inventories.generate.title'),
            'content' => 'entities.pages.inventory._generate',
            'submit' => __('entities/inventories.actions.generate'),
        ])
    </x-form>
@endsection
