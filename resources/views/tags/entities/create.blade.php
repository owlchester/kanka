<?php /** @var \App\Models\Tag $model */ ?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => trans('tags.children.create.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('tags'), 'label' => trans('tags.index.title')],
        ['url' => route('tags.show', $model->id), 'label' => $model->name]
    ]
])

@section('content')
    {!! Form::open(['route' => $formOptions, 'method' => 'POST']) !!}
    @if ($ajax)
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4>{{ trans('tags.children.create.title', ['name' => $model->name]) }}</h4>
        </div>
    @endif
    <div class="modal-body">
        @include('partials.errors')
        @include('tags.entities._form')
    </div>
    <div class="modal-footer">
        <button class="btn btn-success">{{ __('tags.children.actions.add') }}</button>
    </div>
    {!! Form::hidden('tag_id', $model->entity->id) !!}
    {!! Form::close() !!}
@endsection
