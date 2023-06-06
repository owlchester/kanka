<div class="field-font-colour">
    <label class="block w-full">{{ __('maps/markers.fields.font_colour') }}</label><br />
    {!! Form::text($fieldname ?? 'font_colour', \App\Facades\FormCopy::field('font_colour')->string(), [
        'class' => 'form-control spectrum',
        'maxlength' => 6
    ] ) !!}
</div>
