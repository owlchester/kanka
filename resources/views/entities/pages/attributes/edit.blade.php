<?php
/**
 * @var \App\Models\Attribute $attribute
 * @var \App\Models\Entity $entity
 */
$isAdmin = Auth::user()->isAdmin();
?>
@extends('layouts.app', [
    'title' => __('entities/attributes.index.title', ['name' => $entity->name]),
    'description' => '',
    'breadcrumbs' => [
        ['url' => Breadcrumb::index($entity->pluralType()), 'label' => __($parentRoute . '.index.title')],
        ['url' => route($parentRoute . '.show', $entity->child->id), 'label' => $entity->name],
        __('crud.tabs.attributes'),
    ],
    'mainTitle' => false,
])

@section('fullpage-form')
{!! Form::open([
    'url' => route('entities.attributes.save', ['entity' => $entity]),
    'method' => 'POST',
    'data-shortcut' => 1,
    'data-max-fields' => ini_get('max_input_vars'),
    'class' => 'entity-form'
]) !!}
@endsection

@section('content')
    <div class="box box-solid">
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
            @include('cruds.forms.attributes._buttons', ['model' => $entity->child, 'existing' => $r->count()])

        </div>


        <div class="box-footer">
            <div class="pull-right">
                <button class="btn btn-success">
                    {{ __('crud.save') }}
                </button>
            </div>

            <a href="{{ url()->previous() }}" class="btn btn-default">
                {{ __('crud.cancel') }}
            </a>
        </div>

    </div>
@endsection

@section('fullpage-form-end')
    {!! Form::close() !!}
@endsection

@section('scripts')
    <script src="{{ mix('js/attributes.js') }}" defer></script>
@endsection
