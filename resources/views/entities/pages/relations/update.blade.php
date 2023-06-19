<?php /** @var \App\Models\Relation $relation */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/relations.update.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => $entity->url('index'), 'label' => __('entities.' . $entity->pluralType())],
        ['url' => $entity->url('show'), 'label' => $entity->name],
        ['url' => route('entities.relations.index', $entity->id), 'label' => __('crud.tabs.relations')],
    ]
])

@section('content')
    {!! Form::model($relation, ['route' => ['entities.relations.update', $entity->id, $relation], 'method' => 'PATCH', 'data-shortcut' => 1]) !!}

    @include('partials.forms.form', [
        'title' => __('entities/relations.update.title', ['name' => $entity->name]),
        'content' => 'entities.pages.relations._form',
        'deleteID' => '#delete-relation-' . $relation->id
    ])

    @if(!empty($from))
        <input type="hidden" name="from" value="{{ $from }}" />
    @endif
    {!! Form::hidden('owner_id', $entity->id) !!}
    {!! Form::hidden('option', request()->get('option')) !!}
    {!! Form::hidden('mode', request()->get('mode')) !!}

    {!! Form::close() !!}

    {!! Form::open([
        'method' => 'DELETE',
        'route' => ['entities.relations.destroy', 'entity' => $entity->id, 'relation' => $relation->id, 'mode' => request()->mode, 'option' => request()->option],
        'id' => 'delete-relation-' . $relation->id])
        !!}
    @if ($relation->isMirrored())<input type="hidden" name="remove_mirrored" value="1" />@endif
    {!! Form::close() !!}
@endsection
