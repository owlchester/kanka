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

@section('content')
    {!! Form::open(['url' => route('entities.attributes.saveMany', ['entity' => $entity]), 'method' => 'POST', 'data-shortcut' => "1"]) !!}
    <div class="box">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-4">{{ trans('crud.attributes.fields.attribute') }}</div>
                <div class="col-sm-4">{{ trans('crud.attributes.fields.value') }}</div>
                <div class="col-xs-1"><span class="hidden-xs">{{ trans('crud.attributes.fields.is_star') }}</span></div>
                @if ($isAdmin)<div class="col-sm-2">{{ trans('crud.fields.is_private') }}</div>@endif
            </div>
            <div class="entity-attributes">
            @foreach ($r = $entity->attributes()->ordered()->get() as $attribute)
                    @include('cruds.forms.attributes._attribute')
            @endforeach
                <div id="add_attribute_target"></div>
            </div>
            <div id="add_unsortable_attribute_target">


            @include('cruds.forms.attributes._blocks', ['existing' => $r->count()])
        </div>

        <div class="box-footer">
            @include('cruds.forms.attributes._buttons')

            <div class="pull-right">
                <button class="btn btn-success">{{ trans('crud.save') }}</button>
                {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous() . (strpos(url()->previous(), '?tab=') === false ? '?tab=attribute' : null))]) !!}
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('scripts')
    <script src="{{ mix('js/attributes.js') }}" defer></script>
@endsection