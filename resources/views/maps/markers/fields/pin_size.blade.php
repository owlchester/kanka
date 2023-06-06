<div class="field-pin-size">
    <label for="pin_size">{{ __('maps/markers.fields.pin_size') }}</label>
    {!! Form::number($fieldname ?? 'pin_size', \App\Facades\FormCopy::field('pin_size')->string(), [
        'class' => 'form-control',
        'maxlength' => 3,
        'step' => 2,
        'max' => 100,
        'min' => 10,
        'placeholder' => 40,
        'id' => 'pin_size'
    ] ) !!}
</div>
