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
    <div class="row">
        <div class="col-md-8">
            <div class="box box-solid">

                <div class="box-body">
                    <div class="row">
                        <div class="col-md-5">{{ trans('crud.attributes.fields.attribute') }}</div>
                        <div class="col-md-5">{{ trans('crud.attributes.fields.value') }}</div>
                        @if (Auth::user()->isAdmin())<div class="col-md-2">{{ trans('crud.fields.is_private') }}</div>@endif
                    </div>
                    @foreach ($r = $entity->attributes()->orderBy('name', 'ASC')->get() as $attribute)
                        <div class="form-group">
                            <div class="row attribute_row">
                                <div class="col-md-5">
                                    {!! Form::text('name[' . $attribute->id . ']', $attribute->name, ['placeholder' => trans('crud.attributes.placeholders.attribute'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                                </div>
                                <div class="col-md-5">
                                    {!! Form::text('value[' . $attribute->id . ']', $attribute->value, ['placeholder' => trans('crud.attributes.placeholders.value'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                                </div>
                                @if (Auth::user()->isAdmin())
                                <div class="col-md-1">
                                    {!! Form::hidden('is_private[' . $attribute->id . ']', 0) !!}
                                    {!! Form::checkbox('is_private[' . $attribute->id . ']', 1, $attribute->is_private) !!}
                                </div>
                                @endif
                                @can('attribute', [$entity->child, 'delete'])
                                <div class="col-md-1">
                                    <a class="btn btn-danger attribute_delete"><i class="fa fa-trash"></i></a>
                                </div>
                                @endcan
                            </div>
                        </div>
                    @endforeach
                    <div id="add_attribute_target"></div>

                    <div style="display:none;">
                        <div class="form-group" id="attribute_template">
                            <div class="row attribute_row">
                                <div class="col-md-5">
                                    {!! Form::text('name[]', null, ['placeholder' => trans('crud.attributes.placeholders.attribute'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                                </div>
                                <div class="col-md-5">
                                    {!! Form::text('value[]', null, ['placeholder' => trans('crud.attributes.placeholders.value'), 'class' => 'form-control', 'maxlength' => 191]) !!}
                                </div>
                                @if (Auth::user()->isAdmin())
                                <div class="col-md-1">
                                    {!! Form::checkbox('is_private[]', 1, false) !!}
                                </div>
                                @endif
                                <div class="col-md-1">
                                    <button class="btn btn-danger attribute_delete"><i class="fa fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="#" class="btn btn-primary" id="attribute_add"><i class="fa fa-plus"></i> {{ trans('crud.attributes.actions.add') }}</a>

                </div>

                <div class="box-footer">
                    <div class="pull-right">
                        <button class="btn btn-success">{{ trans('crud.save') }}</button>
                        {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous() . (strpos(url()->previous(), '?tab=') === false ? '?tab=attribute' : null))]) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
