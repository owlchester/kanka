@include('cruds.fields.type', ['base' => \App\Models\Ability::class, 'trans' => 'abilities'])

<div class="form-group">
    {!! Form::select2(
        'ability_id',
        (isset($model) && $model->ability ? $model->ability : FormCopy::field('ability')->select(true, \App\Models\Ability::class)),
        App\Models\Ability::class,
        false,
        'abilities.fields.ability'
    ) !!}
</div>
<div class="form-group">
    <label>{{ __('abilities.fields.charges') }}</label>
    {!! Form::text(
        'charges',
        FormCopy::field('charges')->string(),
        [
            'placeholder' => trans('abilities.placeholders.charges'),
            'class' => 'form-control',
            'maxlength' => 120,
            'autocomplete' => 'off'
        ]
    ) !!}
</div>
