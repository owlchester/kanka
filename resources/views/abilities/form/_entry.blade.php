<x-grid>
    @include('cruds.fields.name', ['trans' => 'abilities'])

    @include('cruds.fields.type', ['base' => \App\Models\Ability::class, 'trans' => 'abilities'])

    @include('cruds.fields.ability', ['isParent' => true])

    <div class="charges">
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

    @include('cruds.fields.entry2')

    @include('cruds.fields.tags')
    @include('cruds.fields.image')
</x-grid>
