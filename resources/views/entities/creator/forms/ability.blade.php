<x-grid>
    @include('cruds.fields.type', ['base' => \App\Models\Ability::class, 'trans' => 'abilities'])

    @include('cruds.fields.ability', ['isParent' => true])

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
</x-grid>
