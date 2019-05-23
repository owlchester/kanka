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

            <div class="form-group hidden" id="attribute_template">
                <div class="row attribute_row">
                    <div class="col-sm-4">
                        <div class="input-group">
                            <span class="input-group-addon hidden-xs hidden-sm">
                                <span class="fa fa-arrows-alt-v"></span>
                            </span>
                            {!! Form::text('name[]', null, ['placeholder' => trans('crud.attributes.placeholders.attribute'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                        </div>
                    </div>
                    <div class="col-sm-4">
                        {!! Form::text('value[]', null, ['placeholder' => trans('crud.attributes.placeholders.value'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                    </div>
                    <div class="col-xs-1 text-center">
                        {!! Form::hidden('attr_is_star[]', false) !!}
                        <i class="far fa-star fa-2x"  data-toggle="star" data-tab="{{ __('crud.attributes.visibility.tab') }}" data-entry="{{ __('crud.attributes.visibility.entry') }}" title="{{ __('crud.attributes.visibility.tab') }}"></i>
                    </div>
                    @if ($isAdmin)
                    <div class="col-sm-1 text-center">
                        {!! Form::hidden('is_private[]', false) !!}
                        <i class="fa fa-unlock-alt fa-2x" data-toggle="private" data-private="{{ __('crud.attributes.visibility.private') }}" data-public="{{ __('crud.attributes.visibility.public') }}"></i>
                    </div>
                    @endif
                    <div class="col-sm-1 text-right">
                        <button class="btn btn-danger attribute_delete" title="{{ __('crud.remove') }}"><i class="fa fa-trash"></i></button>
                    </div>
                    {!! Form::hidden('type[]', '') !!}
                </div>
            </div>
            <div class="form-group hidden" id="block_template">
                <div class="row attribute_row">
                    <div class="col-sm-4">
                        <div class="input-group">
                            <span class="input-group-addon hidden-xs hidden-sm">
                                <span class="fa fa-arrows-alt-v"></span>
                            </span>
                            {!! Form::text('name[]', null, ['placeholder' => trans('crud.attributes.placeholders.block'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="hidden">
                            {!! Form::text('value[]', null, ['placeholder' => trans('crud.attributes.placeholders.value'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                        </div>
                    </div>
                    <div class="col-xs-1 text-center">
                        {!! Form::hidden('attr_is_star[]', false) !!}
                        <i class="far fa-star fa-2x"  data-toggle="star" data-tab="{{ __('crud.attributes.visibility.tab') }}" data-entry="{{ __('crud.attributes.visibility.entry') }}" title="{{ __('crud.attributes.visibility.tab') }}"></i>
                    </div>
                    @if ($isAdmin)
                    <div class="col-sm-1 text-center">
                        {!! Form::hidden('is_private[]', false) !!}
                        <i class="fa fa-unlock-alt fa-2x" data-toggle="private" data-private="{{ __('crud.attributes.visibility.private') }}" data-public="{{ __('crud.attributes.visibility.public') }}"></i>
                    </div>
                    @endif
                    <div class="col-sm-1 text-right">
                        <button class="btn btn-danger attribute_delete" title="{{ __('crud.remove') }}"><i class="fa fa-trash"></i></button>
                    </div>
                    {!! Form::hidden('type[]', 'block') !!}
                </div>
            </div>
            <div class="form-group hidden" id="text_template">
                <div class="row attribute_row">
                    <div class="col-sm-4">
                        <div class="input-group">
                            <span class="input-group-addon hidden-xs hidden-sm">
                                <span class="fa fa-arrows-alt-v"></span>
                            </span>
                            {!! Form::text('name[]', null, ['placeholder' => trans('crud.attributes.placeholders.block'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                        </div>
                    </div>
                    <div class="col-sm-4">
                        {!! Form::textarea('value[]', null, ['placeholder' => trans('crud.attributes.placeholders.value'), 'class' => 'form-control', 'rows' => 3]) !!}
                    </div>
                    <div class="col-xs-1 text-center">
                        {!! Form::hidden('attr_is_star[]', false) !!}
                        <i class="far fa-star fa-2x"  data-toggle="star" data-tab="{{ __('crud.attributes.visibility.tab') }}" data-entry="{{ __('crud.attributes.visibility.entry') }}" title="{{ __('crud.attributes.visibility.tab') }}"></i>
                    </div>
                    @if ($isAdmin)
                        <div class="col-sm-1 text-center">
                            {!! Form::hidden('is_private[]', false) !!}
                            <i class="fa fa-unlock-alt fa-2x" data-toggle="private" data-private="{{ __('crud.attributes.visibility.private') }}" data-public="{{ __('crud.attributes.visibility.public') }}"></i>
                        </div>
                    @endif
                    <div class="col-sm-1 text-right">
                        <button class="btn btn-danger attribute_delete" title="{{ __('crud.remove') }}"><i class="fa fa-trash"></i></button>
                    </div>
                    {!! Form::hidden('type[]', 'text') !!}
                </div>
            </div>
            <div class="form-group hidden" id="checkbox_template">
                <div class="row attribute_row">
                    <div class="col-sm-4">
                        <div class="input-group">
                            <span class="input-group-addon hidden-xs hidden-sm">
                                <span class="fa fa-arrows-alt-v"></span>
                            </span>
                            {!! Form::text('name[]', null, ['placeholder' => trans('crud.attributes.placeholders.checkbox'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                        </div>
                    </div>
                    <div class="col-sm-4">
                        {!! Form::checkbox('value[]', 1, false) !!}
                    </div>
                    <div class="col-xs-1 text-center">
                        {!! Form::hidden('attr_is_star[]', false) !!}
                        <i class="far fa-star fa-2x"  data-toggle="star" data-tab="{{ __('crud.attributes.visibility.tab') }}" data-entry="{{ __('crud.attributes.visibility.entry') }}" title="{{ __('crud.attributes.visibility.tab') }}"></i>
                    </div>
                    @if ($isAdmin)
                    <div class="col-sm-1 text-center">
                        {!! Form::hidden('is_private[]', false) !!}
                        <i class="fa fa-unlock-alt fa-2x" data-toggle="private" data-private="{{ __('crud.attributes.visibility.private') }}" data-public="{{ __('crud.attributes.visibility.public') }}"></i>
                    </div>
                    @endif
                    <div class="col-sm-1 text-right">
                        <button class="btn btn-danger attribute_delete" title="{{ __('crud.remove') }}"><i class="fa fa-trash"></i></button>
                    </div>
                    {!! Form::hidden('type[]', 'checkbox') !!}
                </div>
            </div>
        </div>

        <div class="box-footer">

            <div class="btn-group margin-r-5">
                <button class="btn btn-default" id="attribute_add"><i class="fa fa-plus"></i> {{ trans('crud.attributes.types.attribute') }}</button>
                <button class="btn btn-default" id="checkbox_add"><i class="fa fa-check"></i> {{ trans('crud.attributes.types.checkbox') }}</button>
                <button class="btn btn-default" id="text_add"><i class="fas fa-align-justify"></i> {{ trans('crud.attributes.types.text') }}</button>

                {{--<button class="btn btn-default hidden" id="block_add"><i class="fa fa-folder"></i> {{ trans('crud.attributes.types.block') }}</button>--}}
            </div>

            {{--<a class="btn btn-default" data-toggle="modal" data-target="#entity-attribute-template">--}}
                {{--<i class="fa fa-copy"></i> <span class="hidden-xs hidden-sm">{{ trans('crud.attributes.actions.apply_template') }}</span>--}}
            {{--</a>--}}

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