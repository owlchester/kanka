<?php
/** @var \App\Models\Attribute $attribute */
$id = isset($resetAttributeId) ? -$attribute->id : $attribute->id;
?>

<div class="form-group">
    <div class="row attribute_row">
        <div class="col-xs-12 col-sm-4">
            <div class="input-group">
                <span class="input-group-addon hidden-xs hidden-sm">
                    <span class="fa fa-arrows-alt-v"></span>
                </span>
                {!! Form::text('attr_name[' . $id . ']', $attribute->name, ['placeholder' => trans('crud.attributes.placeholders.attribute'), 'class' => 'form-control', 'maxlength' => 191]) !!}
            </div>
        </div>
        <div class="col-xs-7 col-sm-4 col-md-5 col-lg-6">
            @if ($attribute->isCheckbox())
                {!! Form::hidden('attr_value[' . $id . ']', 0) !!}
                {!! Form::checkbox('attr_value[' . $id . ']', 1, $attribute->value) !!}
            @elseif ($attribute->isBlock())
                {!! Form::hidden('attr_value[' . $id . ']', $attribute->value) !!}
            @elseif ($attribute->isText())
                {!! Form::textarea('attr_value[' . $id . ']', $attribute->value, ['placeholder' => __('crud.attributes.placeholders.value'), 'class' => 'form-control', 'rows' => 4]) !!}
            @elseif ($attribute->isSection())
                {!! Form::hidden('attr_value[' . $id . ']', $attribute->value) !!}
            @else
                {!! Form::text('attr_value[' . $id . ']', $attribute->value, ['placeholder' => trans('crud.attributes.placeholders.value'), 'class' => 'form-control', 'maxlength' => 191]) !!}
            @endif
        </div>
        <div class="col-xs-5 col-sm-4 col-md-3 col-lg-2">
            {!! Form::hidden('attr_is_star[' . $id . ']', $attribute->is_star) !!}
            <i class="fa-star margin-r-5 @if($attribute->is_star) fas @else far @endif fa-2x" data-toggle="star" data-tab="{{ __('crud.attributes.visibility.tab') }}" data-entry="{{ __('crud.attributes.visibility.entry') }}" title="@if($attribute->is_star) {{ __('crud.attributes.visibility.entry') }} @else  {{ __('crud.attributes.visibility.tab') }} @endif"></i>

{{--            {!! Form::hidden('attr_is_editable[' . $id . ']', $attribute->is_editable) !!}--}}
{{--            <i class="fa-edit margin-r-5 @if($attribute->is_editable) fas @else far @endif fa-2x" data-toggle="star" data-tab="{{ __('crud.attributes.editable.false') }}" data-entry="{{ __('crud.attributes.editable.true') }}" title="@if($attribute->is_editable) {{ __('crud.attributes.editable.true') }} @else  {{ __('crud.attributes.editable.false') }} @endif"></i>--}}

            @if ($isAdmin)
            {!! Form::hidden('attr_is_private[' . $id . ']', $attribute->is_private) !!}
            <i class="fa @if($attribute->is_private) fa-lock @else fa-unlock-alt @endif fa-2x" data-toggle="private" data-private="{{ __('crud.attributes.visibility.private') }}" data-public="{{ __('crud.attributes.visibility.public') }}"></i>
            @endif
            @if (!isset($model) || auth()->user()->can('attribute', [$model, 'delete']))
                    <a class="text-danger attribute_delete pull-right" title="{{ __('crud.remove') }}"><i class="fa fa-trash fa-2x"></i></a>
            @endcan
        </div>

        {!! Form::hidden('attr_type[' . $id . ']', $attribute->type) !!}
    </div>
</div>
