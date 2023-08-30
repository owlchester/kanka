
<x-grid type="1/1">
    <x-forms.field
        field="ability"
        :label="__('entities.ability')">
        {!! $ability->ability->tooltipedLink() !!}
        {!! Form::hidden('ability_id', $ability->ability_id) !!}
    </x-forms.field>

    <x-forms.field
        field="note"
        :label="__('entities/abilities.fields.note')"
        :helper="__('entities/abilities.helpers.note', [
        'code' => '<code>[character:4096]</code>',
        'attr' => '<code>{Strength}</code>'
    ])"
        :tooltip="true">
        {!! Form::textarea('note', null, ['class' => '', 'rows' => 4]) !!}
    </x-forms.field>

    @include('cruds.fields.visibility_id', ['model' => $ability])
</x-grid>
