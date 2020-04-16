<div class="form-group">
    <label>{{ trans($trans . '.fields.position') }}</label>
    {!! Form::number('position', FormCopy::field('position')->string(), ['class' => 'form-control', 'maxlength' => 1]) !!}
    <p class="help-block">{{ __($trans . '.helpers.position') }}</p>
</div>
