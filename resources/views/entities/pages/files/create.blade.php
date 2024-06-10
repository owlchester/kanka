@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/files.create.title', ['entity' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($entity)->list(),
        Breadcrumb::show(),
        ['url' => route('entities.entity_assets.index', [$campaign, $entity->id]), 'label' => __('crud.tabs.assets')],
    ],
    'centered' => true,
])

@section('content')
    <x-form :action="['entities.entity_assets.store', $campaign, $entity]" files class="ajax-subform">
        @include('partials.forms.form', [
            'title' => __('entities/files.create.title', ['entity' => $entity->name]),
            'content' => 'entities.pages.files._form',
            'dialog' => true,
        ])
        <input type="hidden" name="type_id" value="{{ \App\Models\EntityAsset::TYPE_FILE }}" />
    </x-form>
@endsection
