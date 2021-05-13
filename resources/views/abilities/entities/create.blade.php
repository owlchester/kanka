<?php /** @var \App\Models\Ability $model */ ?>
@extends('layouts.' . ($ajax ? 'ajax' : 'app'), [
    'title' => trans('abilities.children.create.title', ['name' => $model->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index('abilities'), 'label' => trans('abilities.index.title')],
        ['url' => route('abilities.show', $model->id), 'label' => $model->name]
    ]
])

@section('content')
    <div class="panel panel-default">
        @if ($ajax)
            <div class="panel-heading">
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ trans('crud.delete_modal.close') }}">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4>{{ trans('abilities.children.create.title', ['name' => $model->name]) }}</h4>
            </div>
        @endif
        <div class="panel-body">
            @include('partials.errors')

            {!! Form::open(['route' => $formOptions, 'method' => 'POST']) !!}
            @include('abilities.entities._form')
            {!! Form::hidden('ability_id', $model->entity->id) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection
