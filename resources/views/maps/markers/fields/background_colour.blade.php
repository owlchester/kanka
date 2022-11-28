<div class="form-group">
    <label>{{ __('locations.map.points.fields.colour') }}</label><br />
    {!! Form::text($fieldname ?? 'colour', \App\Facades\FormCopy::field('colour')->string(), [
    'class' => 'form-control spectrum',
    'maxlength' => 6
] ) !!}
</div>
