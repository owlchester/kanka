<div class="row">
    <div class="col-sm-6">
        @include('cruds.fields.type', ['base' => \App\Models\Ability::class, 'trans' => 'abilities'])
    </div>
    <div class="col-sm-6">
        @include('cruds.fields.ability', ['isParent' => true])
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label>{{ __('abilities.fields.charges') }}</label>
            {!! Form::text(
                'charges',
                FormCopy::field('charges')->string(),
                [
                    'placeholder' => __('abilities.placeholders.charges'),
                    'class' => 'form-control',
                    'maxlength' => 120,
                    'autocomplete' => 'off'
                ]
            ) !!}
        </div>
    </div>
</div>
