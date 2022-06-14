<div class="form-group">
    <label>{{ __('characters.fields.title') }}</label>
    {!! Form::text('title', FormCopy::field('title')->string(), ['placeholder' => __('characters.placeholders.title'), 'class' => 'form-control', 'maxlength' => 191, 'spellcheck' => 'true']) !!}
</div>
