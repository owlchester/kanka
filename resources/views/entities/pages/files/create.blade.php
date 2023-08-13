@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/files.create.title', ['entity' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($entity)->list(),
        Breadcrumb::show(),
        ['url' => route('entities.entity_assets.index', [$campaign, $entity->id]), 'label' => __('crud.tabs.assets')],
    ]
])

@section('content')
    {!! Form::open(['route' => ['entities.entity_assets.store', $campaign, $entity], 'method'=>'POST', 'data-shortcut' => 1, 'enctype' => 'multipart/form-data']) !!}

    @include('partials.forms.form', [
            'title' => __('entities/files.create.title', ['entity' => $entity->name]),
            'content' => 'entities.pages.files._form',
        ])
    <input type="hidden" name="type_id" value="{{ \App\Models\EntityAsset::TYPE_FILE }}" />
    {!! Form::close() !!}
@endsection
