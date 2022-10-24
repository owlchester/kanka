<div class="form-group required">
    <label>{{ __('crud.fields.colour') }}</label>
    {!! Form::select('colour', FormCopy::colours(), FormCopy::field('colour')->string(), ['class' => 'form-control select2-colour']) !!}
</div>
