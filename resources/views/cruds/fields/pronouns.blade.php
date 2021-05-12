<div class="form-group">
    <label>{{ trans('characters.fields.pronouns') }}</label>
    {!! Form::text(
        'pronouns',
        null,
        [
            'placeholder' => trans('characters.placeholders.pronouns'),
            'class' => 'form-control',
            'maxlength' => 45,
        ]
    ) !!}
</div>
