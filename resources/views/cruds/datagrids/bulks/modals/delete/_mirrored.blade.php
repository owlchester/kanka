<p>
<x-forms.field field="delete-mirror" :label="__('entities/relations.bulk.fields.delete_mirrored')">
    <input type="hidden" name="delete_mirrored" value="0"/>
    <x-checkbox :text="__('entities/relations.bulk.helpers.delete_mirrored')">
        <input type="checkbox" name="delete_mirrored" value="1" @if (old('delete_mirrored', false)) checked="checked" @endif />
    </x-checkbox>
</x-forms.field>
</p>
