<div class="form-group">
    <label>{{ trans('characters.fields.title') }}</label>
    {!! Form::text('title', (isset($isRandom) && $isRandom ? $random->generate('title') : FormCopy::field('title')->string()), ['placeholder' => trans('characters.placeholders.title'), 'class' => 'form-control', 'maxlength' => 191]) !!}
</div>