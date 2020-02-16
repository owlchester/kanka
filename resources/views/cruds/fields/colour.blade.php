<div class="form-group required">
    <label>{{ trans('crud.fields.colour') }}</label>
    {!! Form::select('colour', FormCopy::colours(), FormCopy::field('colour')->string(), ['class' => 'form-control']) !!}
</div>
