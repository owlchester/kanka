@extends('layouts.app', [
    'title' => __('entities/notes.create.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route($parentRoute . '.index'), 'label' => trans($parentRoute . '.index.title')],
        ['url' => route($parentRoute . '.show', $entity->child->id), 'label' => $entity->name]
    ]
])
@inject('campaign', 'App\Services\CampaignService')


@section('fullpage-form')
    {!! Form::open(['route' => ['entities.entity_notes.store', $entity->id], 'method'=>'POST', 'data-shortcut' => '1', 'id' => 'entity-form', 'class' => 'entity-note-form']) !!}
@endsection

@section('content')
    @include('partials.errors')
    @include('cruds.notes._create')
@endsection

@include('editors.editor')


@section('fullpage-form-end')
    {!! Form::close() !!}
@endsection
