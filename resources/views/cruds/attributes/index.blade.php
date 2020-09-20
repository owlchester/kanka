<?php
/**
 * @var \App\Models\Attribute $attribute
 * @var \App\Models\Entity $entity
 */
$isAdmin = Auth::user()->isAdmin();
?>
@extends('layouts.app', [
    'title' => trans('crud.attributes.index.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => route($parentRoute . '.index'), 'label' => trans($parentRoute . '.index.title')],
        ['url' => route($parentRoute . '.show', $entity->child->id), 'label' => $entity->name],
        trans('crud.tabs.attributes'),
    ]
])

@section('fullpage-form')
    {!! Form::open(['url' => route('entities.attributes.saveMany', ['entity' => $entity]), 'method' => 'POST', 'data-shortcut' => 1, 'class' => 'entity-form']) !!}
@endsection

@section('content')
    <div class="box">
        <div class="box-header">

            <button class="btn btn-success pull-right">{{ trans('crud.save') }}</button>
        </div>
        <div class="box-body">

            <div id="entity-attributes-all">
                <div class="entity-attributes">
                @foreach ($r = $entity->attributes()->ordered()->get() as $attribute)
                        @include('cruds.forms.attributes._attribute')
                @endforeach
                    <div id="add_attribute_target"></div>
                </div>
                <div id="add_unsortable_attribute_target"></div>
            </div>


            @include('cruds.forms.attributes._blocks', ['existing' => $r->count()])
        </div>

        <div class="box-footer">
            @include('cruds.forms.attributes._buttons', ['model' => $entity->child])
        </div>
    </div>
@endsection

@section('fullpage-form-end')
    {!! Form::close() !!}
@endsection

@section('scripts')
    <script src="{{ mix('js/attributes.js') }}" defer></script>
@endsection
