@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/links.create.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($entity)->list(),
        Breadcrumb::show(),
        ['url' => route('entities.entity_assets.index', [$campaign, $entity->id]), 'label' => trans('crud.tabs.assets')],
    ],
    'centered' => true,
])

@section('content')
    <x-form :action="['entities.entity_assets.store', $campaign, $entity]">
        @include('partials.forms._dialog', [
            'title' => __('entities/links.create.title', ['name' => $entity->name]),
            'content' => 'entities.pages.links._form',
        ])
    </x-form>
@endsection
