
<div class="form-group required">
    <label>{{ __('crud.fields.name') }}</label>
    {!! Form::text('name', null, ['placeholder' => __('maps/groups.placeholders.name'), 'class' => 'form-control', 'maxlength' => 191]) !!}
</div>

@include('cruds.fields.visibility_id')

<div class="form-group">
    {!! Form::hidden('is_shown', 0) !!}
    <label>{!! Form::checkbox('is_shown', 1, isset($model) ? $model->is_shown : 1) !!}
        {{ __('maps/groups.fields.is_shown') }}
    </label>
    <p class="help-block">{{ __('maps/groups.hints.is_shown') }}</p>
</div>

<div class="form-group">
    <label>{{ __('maps/groups.fields.position') }}</label>
    {!! Form::number('position', null, ['placeholder' => __('maps/groups.placeholders.position'), 'class' => 'form-control', 'maxlength' => 3]) !!}
</div>
