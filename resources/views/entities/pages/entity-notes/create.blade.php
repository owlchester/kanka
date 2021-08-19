@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/notes.create.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route($parentRoute . '.index'), 'label' => trans($parentRoute . '.index.title')],
        ['url' => route($parentRoute . '.show', $entity->child->id), 'label' => $entity->name],
        __('entities/notes.actions.add')
    ]
])
@inject('campaign', 'App\Services\CampaignService')


@section('fullpage-form')
    {!! Form::open(['route' => ['entities.entity_notes.store', $entity->id], 'method'=>'POST', 'data-shortcut' => '1', 'id' => 'entity-form', 'class' => 'entity-form entity-note-form']) !!}
@endsection

@section('content')
    @include('entities.pages.entity-notes._form')

    @include('entities.pages.entity-notes._save-options')

@endsection

@include('editors.editor')


@section('fullpage-form-end')
    {!! Form::close() !!}
@endsection
