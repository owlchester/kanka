
<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'abilities'])
        @include('cruds.fields.type', ['base' => \App\Models\Ability::class, 'trans' => 'abilities'])
        <div class="form-group">
            {!! Form::foreignSelect(
                'ability_id',
                [
                    'preset' => (isset($model) && $model->ability ? $model->ability : FormCopy::field('ability')->select(true, \App\Models\Ability::class)),
                    'class' => App\Models\Ability::class,
                    'enableNew' => true,
                    'labelKey' => 'abilities.fields.ability',
                    'from' => isset($model) ? $model : null
                ]
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
        @include('cruds.fields.tags')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.entry2')
        @include('cruds.fields.image')
    </div>
</div>

@include('cruds.fields.private2')
