<div class="field field-bg-colour">
    <label class="m-0">{{ __('maps/markers.fields.bg_colour') }}</label><br />
    <span>
        {!! Form::text($fieldname ?? 'colour', \App\Facades\FormCopy::field('colour')->string(), [
            'class' => 'spectrum',
            'maxlength' => 6
        ] ) !!}
    </span>
</div>
