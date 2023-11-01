<x-forms.field field="opacity" :label="__('maps/markers.fields.opacity')">
    {!! Form::number($fieldname ?? 'opacity', (!empty($source) ? $source->opacity : (isset($model) ? $model->opacity : (!isset($fieldname) ? 100 : null))), [
    'class' => '',
    'maxlength' => 3,
    'step' => 10,
    'max' => 100,
    'min' => 0,
    'id' => 'opacity'
    ]) !!}
</x-forms.field>
