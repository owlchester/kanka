@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/files.create.title', ['entity' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::campaign($campaign)->entity($entity)->list(),
        Breadcrumb::show(),
        ['url' => route('entities.entity_assets.index', [$campaign, $entity->id]), 'label' => __('crud.tabs.assets')],
    ],
    'centered' => true,
])

@section('content')
    <x-form :action="['entities.entity_assets.store', $campaign, $entity]" files>
        @include('partials.forms._dialog', [
            'title' => __('entities/files.create.title', ['entity' => $entity->name]),
            'content' => 'entities.pages.files._form',
        ])
        <input type="hidden" name="type_id" value="{{ \App\Enums\EntityAssetType::file }}" />
    </x-form>
@endsection
