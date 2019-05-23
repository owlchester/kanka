<?php
/** @var \App\Models\Attribute $attribute */
$id = isset($resetAttributeId) ? null : $attribute->id;
?>

<div class="form-group">
    <div class="row attribute_row">
        <div class="col-xs-4">
            <div class="input-group">
                <span class="input-group-addon hidden-xs hidden-sm">
                    <span class="fa fa-arrows-alt-v"></span>
                </span>
                {!! Form::text('attr_name[' . $id . ']', $attribute->name, ['placeholder' => trans('crud.attributes.placeholders.attribute'), 'class' => 'form-control', 'maxlength' => 191]) !!}
            </div>
        </div>
        <div class="col-xs-4">
            @if ($attribute->isCheckbox())
                {!! Form::hidden('attr_value[' . $id . ']', 0) !!}
                {!! Form::checkbox('attr_value[' . $id . ']', 1, $attribute->value) !!}
            @elseif ($attribute->isBlock())
                {!! Form::hidden('attr_value[' . $id . ']', $attribute->value) !!}
            @elseif ($attribute->isText())
                {!! Form::textarea('attr_value[' . $id . ']', $attribute->value, ['placeholder' => __('crud.attributes.placeholders.value'), 'class' => 'form-control', 'rows' => 4]) !!}
            @else
                {!! Form::text('attr_value[' . $id . ']', $attribute->value, ['placeholder' => trans('crud.attributes.placeholders.value'), 'class' => 'form-control', 'maxlength' => 191]) !!}
            @endif
        </div>
        <div class="col-xs-1 text-center">
            {!! Form::hidden('attr_is_star[' . $id . ']', $attribute->is_star) !!}
            <i class="fa-star @if($attribute->is_star) fas @else far @endif fa-2x" data-toggle="star" data-tab="{{ __('crud.attributes.visibility.tab') }}" data-entry="{{ __('crud.attributes.visibility.entry') }}" title="@if($attribute->is_star) {{ __('crud.attributes.visibility.entry') }} @else  {{ __('crud.attributes.visibility.tab') }} @endif"></i>
        </div>
        @if ($isAdmin)
            <div class="col-xs-1 text-center">
                {!! Form::hidden('attr_is_private[' . $id . ']', $attribute->is_private) !!}
                <i class="fa @if($attribute->is_private) fa-lock @else fa-unlock-alt @endif fa-2x" data-toggle="private" data-private="{{ __('crud.attributes.visibility.private') }}" data-public="{{ __('crud.attributes.visibility.public') }}"></i>
            </div>
        @endif
        @if (!isset($model) || auth()->user()->can('attribute', [$model, 'delete']))
            <div class="col-xs-1 text-right">
                <a class="btn btn-danger attribute_delete" title="{{ __('crud.remove') }}"><i class="fa fa-trash"></i></a>
            </div>
        @endcan
        {!! Form::hidden('attr_type[' . $id . ']', $attribute->type) !!}
    </div>
</div>