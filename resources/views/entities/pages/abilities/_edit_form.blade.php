
<x-grid type="1/1">
    <x-forms.field
        field="ability"
        :label="__('entities.ability')">
        <x-entity-link
            :entity="$ability->ability->entity"
            :campaign="$campaign" />
        <input type="hidden" name="ability_id" value="{{ $ability->ability_id }}" />
    </x-forms.field>

    <x-forms.field
        field="note"
        :label="__('entities/abilities.fields.note')">
        <textarea name="note" class="w-full" rows="4">{!! $ability->note ?? null !!}</textarea>
        <x-slot name="helper">
            {!! __('entities/abilities.helpers.note', [
                'code' => '<code>[character:4092]</code>',
                'attr' => '<code>{Strength}</code>'
            ]) !!}
        </x-slot>
    </x-forms.field>

    @include('cruds.fields.visibility_id', ['model' => $ability])
</x-grid>
