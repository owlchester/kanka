@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/relations.create.new_title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($entity)->list(),
        Breadcrumb::show(),
        ['url' => route('entities.relations.index', [$campaign, $entity->id]), 'label' => __('crud.tabs.relations')],
        __('crud.actions.new')
    ],
    'centered' => true,
])

@section('content')
    <x-form :action="['entities.relations.store', $campaign, $entity->id]">
        @include('partials.forms._dialog', [
                'title' => __('entities/relations.create.new_title', ['name' => $entity->name]),
                'content' => 'entities.pages.relations._form',
            ])

        <input type="hidden" name="entity_id" value="{{ $entity->id }}" />
        <input type="hidden" name="owner_id" value="{{ $entity->id }}" />
    </x-form>
@endsection
