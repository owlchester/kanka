<div class="form-group">
    <label for="opacity">{{ __('maps/markers.fields.opacity') }}</label><br />
    {!! Form::number($fieldname ?? 'opacity', (!empty($source) ? $source->opacity : (isset($model) ? $model->opacity : (!isset($fieldname) ? 100 : null))), [
    'class' => 'form-control',
    'maxlength' => 3,
    'step' => 10,
    'max' => 100,
    'min' => 0,
    'id' => 'opacity'
    ]) !!}
</div>
