
<div class="row">
    <div class="col-md-6">
        @include('cruds.fields.name', ['trans' => 'abilities'])
        @include('cruds.fields.type', ['base' => \App\Models\Ability::class, 'trans' => 'abilities'])
        <div class="form-group">
            {!! Form::select2(
                'ability_id',
                (isset($model) && $model->ability ? $model->ability : FormCopy::field('ability')->select(true, \App\Models\Ability::class)),
                App\Models\Ability::class,
                true,
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
        @include('cruds.fields.tags')

        @include('cruds.fields.private')
    </div>
    <div class="col-md-6">
        @include('cruds.fields.entry2')
        @include('cruds.fields.image')
    </div>
</div>
