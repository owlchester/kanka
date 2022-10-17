
<div class="form-group required">
    <label>{{ __('crud.fields.name') }}</label>
    {!! Form::text('name', null, ['placeholder' => __('maps/groups.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191, 'required' => true]) !!}
</div>

@include('cruds.fields.visibility_id')

<div class="form-group">
    {!! Form::hidden('is_shown', 0) !!}
    <label>{!! Form::checkbox('is_shown', 1, isset($model) ? $model->is_shown : 1) !!}
        {{ __('maps/groups.fields.is_shown') }}
    </label>
    <p class="help-block">{{ __('maps/groups.hints.is_shown') }}</p>
</div>

@php 
    $options = $map->groupPositionOptions();
    $last = array_key_last($options);
@endphp

<div class="form-group">
    <label>{{ __('maps/groups.fields.position') }}</label>
    {!! Form::select('position', $options, (!empty($group) ? $group : $last), ['class' => 'form-control']) !!}
</div>
