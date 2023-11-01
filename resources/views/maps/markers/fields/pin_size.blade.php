<x-forms.field field="pin-size" :label="__('maps/markers.fields.pin_size')">
    {!! Form::number($fieldname ?? 'pin_size', \App\Facades\FormCopy::field('pin_size')->string(), [
        'class' => '',
        'maxlength' => 3,
        'step' => 2,
        'max' => 100,
        'min' => 10,
        'placeholder' => 40,
        'id' => 'pin_size'
    ] ) !!}
</x-forms.field>
