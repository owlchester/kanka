<?php
/**
 * @var Attribute $attribute
 * @var \App\Models\AttributeTemplate $attributeTemplate
 */
$attributes = isset($model) ? $model->entity->attributes()->orderBy('default_order', 'ASC')->get() : (isset($source) ? $source->entity->attributes: []);
$isAdmin = Auth::user()->isAdmin();
$existingAttributeNames = [];
foreach ($attributes as $attribute) {
    $existingAttributeNames[] = $attribute->name;
}
?>

@include('cruds.fields.attribute_template')

<div class="row">
    <div class="col-xs-4">{{ trans('crud.attributes.fields.attribute') }}</div>
    <div class="col-xs-4">{{ trans('crud.attributes.fields.value') }}</div>
    <div class="col-xs-1"><span class="hidden-xs">{{ trans('crud.attributes.fields.is_star') }}</span></div>
    @if ($isAdmin)<div class="col-xs-2"><span class="hidden-xs">{{ trans('crud.fields.is_private') }}</span></div>@endif
</div>
<div class="entity-attributes">
    @foreach ($attributes as $attribute)
        @include('cruds.forms.attributes._attribute')
    @endforeach
    @if (isset($entityAttributeTemplates))
        @foreach ($entityAttributeTemplates as $attributeTemplate)
            @include('cruds.forms.attributes._template')
        @endforeach
    @endif
    <div id="add_attribute_target"></div>
</div>

<div class="form-group hidden" id="attribute_template">
    <div class="row attribute_row">
        <div class="col-xs-4">
            <div class="input-group">
                <span class="input-group-addon hidden-xs hidden-sm">
                    <span class="fa fa-arrows-alt-v"></span>
                </span>
                {!! Form::text('attr_name[]', null, [
                    'placeholder' => __('crud.attributes.placeholders.attribute'),
                    'class' => 'form-control',
                    'maxlength' => 191
                ]) !!}
            </div>
        </div>
        <div class="col-xs-4">
            {!! Form::text('attr_value[]', null, ['placeholder' => trans('crud.attributes.placeholders.value'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>
        <div class="col-xs-1 text-center">
            {!! Form::hidden('attr_is_star[]', false) !!}
            <i class="far fa-star fa-2x"  data-toggle="star" data-tab="{{ __('crud.attributes.visibility.tab') }}" data-entry="{{ __('crud.attributes.visibility.entry') }}" title="{{ __('crud.attributes.visibility.tab') }}"></i>
        </div>
        @if ($isAdmin)
            <div class="col-xs-1 text-center">
                {!! Form::hidden('attr_is_private[]', false) !!}
                <i class="fa fa-unlock-alt fa-2x" data-toggle="private" data-private="{{ __('crud.attributes.visibility.private') }}" data-public="{{ __('crud.attributes.visibility.public') }}"></i>
            </div>
        @endif
        <div class="col-xs-1 text-right">
            <button class="btn btn-danger attribute_delete" title="{{ __('crud.remove') }}"><i class="fa fa-trash"></i></button>
        </div>
        {!! Form::hidden('attr_type[]', '') !!}
    </div>
</div>
<div class="form-group hidden" id="block_template">
    <div class="row attribute_row">
        <div class="col-xs-4">
            <div class="input-group">
                <span class="input-group-addon hidden-xs hidden-sm">
                    <span class="fa fa-arrows-alt-v"></span>
                </span>
                {!! Form::text('attr_name[]', null, ['placeholder' => trans('crud.attributes.placeholders.block'), 'class' => 'form-control', 'maxlength' => 191]) !!}
            </div>
        </div>
        <div class="col-xs-4">
            <div class="hidden">
                {!! Form::text('attr_value[]', null, ['placeholder' => trans('crud.attributes.placeholders.value'), 'class' => 'form-control', 'maxlength' => 191]) !!}
            </div>
        </div>
        <div class="col-xs-1 text-center">
            {!! Form::hidden('attr_is_star[]', false) !!}
            <i class="far fa-star fa-2x"  data-toggle="star" data-tab="{{ __('crud.attributes.visibility.tab') }}" data-entry="{{ __('crud.attributes.visibility.entry') }}" title="{{ __('crud.attributes.visibility.tab') }}"></i>
        </div>
        @if ($isAdmin)
            <div class="col-xs-1 text-center">
                {!! Form::hidden('attr_is_private[]', false) !!}
                <i class="fa fa-unlock-alt fa-2x" data-toggle="private" data-private="{{ __('crud.attributes.visibility.private') }}" data-public="{{ __('crud.attributes.visibility.public') }}"></i>
            </div>
        @endif
        <div class="col-xs-1 text-right">
            <button class="btn btn-danger attribute_delete" title="{{ __('crud.remove') }}"><i class="fa fa-trash"></i></button>
        </div>
        {!! Form::hidden('attr_type[]', 'block') !!}
    </div>
</div>
<div class="form-group hidden" id="text_template">
    <div class="row attribute_row">
        <div class="col-xs-4">
            <div class="input-group">
                <span class="input-group-addon hidden-xs hidden-sm">
                    <span class="fa fa-arrows-alt-v"></span>
                </span>
                {!! Form::text('attr_name[]', null, ['placeholder' => trans('crud.attributes.placeholders.block'), 'class' => 'form-control', 'maxlength' => 191]) !!}
            </div>
        </div>
        <div class="col-xs-4">
            {!! Form::textarea('attr_value[]', null, ['placeholder' => trans('crud.attributes.placeholders.value'), 'class' => 'form-control', 'rows' => 3]) !!}
        </div>
        <div class="col-xs-1 text-center">
            {!! Form::hidden('attr_is_star[]', false) !!}
            <i class="far fa-star fa-2x"  data-toggle="star" data-tab="{{ __('crud.attributes.visibility.tab') }}" data-entry="{{ __('crud.attributes.visibility.entry') }}" title="{{ __('crud.attributes.visibility.tab') }}"></i>
        </div>
        @if ($isAdmin)
            <div class="col-xs-1 text-center">
                {!! Form::hidden('attr_is_private[]', false) !!}
                <i class="fa fa-unlock-alt fa-2x" data-toggle="private" data-private="{{ __('crud.attributes.visibility.private') }}" data-public="{{ __('crud.attributes.visibility.public') }}"></i>
            </div>
        @endif
        <div class="col-xs-1 text-right">
            <button class="btn btn-danger attribute_delete" title="{{ __('crud.remove') }}"><i class="fa fa-trash"></i></button>
        </div>
        {!! Form::hidden('attr_type[]', 'text') !!}
    </div>
</div>
<div class="form-group hidden" id="checkbox_template">
    <div class="row attribute_row">
        <div class="col-xs-4">
            <div class="input-group">
                <span class="input-group-addon hidden-xs hidden-sm">
                    <span class="fa fa-arrows-alt-v"></span>
                </span>
                {!! Form::text('attr_name[]', null, ['placeholder' => trans('crud.attributes.placeholders.checkbox'), 'class' => 'form-control', 'maxlength' => 191]) !!}
            </div>
        </div>
        <div class="col-xs-4">
            {!! Form::checkbox('attr_value[]', 1, false) !!}
        </div>
        <div class="col-xs-1 text-center">
            {!! Form::hidden('attr_is_star[]', false) !!}
            <i class="far fa-star fa-2x"  data-toggle="star" data-tab="{{ __('crud.attributes.visibility.tab') }}" data-entry="{{ __('crud.attributes.visibility.entry') }}" title="{{ __('crud.attributes.visibility.tab') }}"></i>
        </div>
        @if ($isAdmin)
            <div class="col-xs-1 text-center">
                {!! Form::hidden('attr_is_private[]', false) !!}
                <i class="fa fa-unlock-alt fa-2x" data-toggle="private" data-private="{{ __('crud.attributes.visibility.private') }}" data-public="{{ __('crud.attributes.visibility.public') }}"></i>
            </div>
        @endif
        <div class="col-xs-1 text-right">
            <button class="btn btn-danger attribute_delete" title="{{ __('crud.remove') }}"><i class="fa fa-trash"></i></button>
        </div>
        {!! Form::hidden('attr_type[]', 'checkbox') !!}
    </div>
</div>

<div class="btn-group margin-r-5">
    <button class="btn btn-default" id="attribute_add">
        <i class="fa fa-plus"></i> <span class="hidden-xs">{{ trans('crud.attributes.types.attribute') }}</span>
    </button>
    <button class="btn btn-default" id="checkbox_add">
        <i class="fa fa-check"></i> <span class="hidden-xs">{{ trans('crud.attributes.types.checkbox') }}</span>
    </button>
    <button class="btn btn-default" id="text_add">
        <i class="fas fa-align-justify"></i> <span class="hidden-xs">{{ trans('crud.attributes.types.text') }}</span>
    </button>
</div>

@section('scripts')
    @parent
    <script src="{{ mix('js/attributes.js') }}" defer></script>
@endsection