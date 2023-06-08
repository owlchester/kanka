<div class="colour required">
    <label>{{ __('crud.fields.colour') }}</label><br />
    {!! Form::select('colour', FormCopy::colours(), FormCopy::field('colour')->string(), ['class' => 'form-control select2-colour']) !!}
</div>
