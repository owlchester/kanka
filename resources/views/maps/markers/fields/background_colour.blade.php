<div class="field-bg-colour">
    <label>{{ __('maps/markers.fields.bg_colour') }}</label><br />
    {!! Form::text($fieldname ?? 'colour', \App\Facades\FormCopy::field('colour')->string(), [
    'class' => 'form-control spectrum',
    'maxlength' => 6
] ) !!}
</div>
