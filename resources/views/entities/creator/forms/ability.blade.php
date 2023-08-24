<x-grid>
    @include('cruds.fields.type', ['base' => \App\Models\Ability::class, 'trans' => 'abilities'])

    @include('cruds.fields.ability', ['isParent' => true])

    <x-forms.field
        field="charges"
        :label="__('abilities.fields.charges')">
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
    </x-forms.field>
</x-grid>
