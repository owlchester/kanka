<?php /** @var \App\Models\Relation $relation */?>
@extends('layouts.' . (request()->ajax() ? 'ajax' : 'app'), [
    'title' => __('entities/relations.update.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        Breadcrumb::entity($entity)->list(),
        Breadcrumb::show(),
        ['url' => route('entities.relations.index', [$campaign, $entity->id]), 'label' => __('crud.tabs.relations')],
    ],
    'centered' => true,
])

@section('content')
    {!! Form::model($relation, ['route' => ['entities.relations.update', $campaign, $entity->id, $relation], 'method' => 'PATCH', 'data-shortcut' => 1, 'class' => 'ajax-subform']) !!}

    @include('partials.forms.form', [
        'title' => __('entities/relations.update.title', ['name' => link_to($entity->url(), $entity->name)]),
        'content' => 'entities.pages.relations._form',
        'deleteID' => '#delete-relation-' . $relation->id,
        'dialog' => true,
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
        'route' => ['entities.relations.destroy', 'campaign' => $campaign, 'entity' => $entity->id, 'relation' => $relation->id, 'mode' => request()->mode, 'option' => request()->option],
        'id' => 'delete-relation-' . $relation->id])
        !!}
    @if ($relation->isMirrored())<input type="hidden" name="remove_mirrored" value="1" />@endif
    {!! Form::close() !!}
@endsection
