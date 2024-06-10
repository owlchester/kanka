<x-forms.field field="mirror" :label="__('entities/relations.bulk.fields.update_mirrored')">
    <input type="hidden" name="update_mirrored" value="0"/>
    <x-checkbox :text="__('entities/relations.bulk.helpers.update_mirrored')">
        <input type="checkbox" name="update_mirrored" value="1" @if (old('update_mirrored', false)) checked="checked" @endif />
    </x-checkbox>
</x-forms.field>
