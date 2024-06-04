<x-forms.field field="unmirror" :label="__('entities/relations.bulk.fields.unmirror')">
    <input type="hidden" name="unmirror" value="0"/>
    <x-checkbox :text="__('entities/relations.bulk.helpers.unmirror')">
        <input type="checkbox" name="unmirror" value="1" @if (old('unmirror', false)) checked="checked" @endif />
    </x-checkbox>
</x-forms.field>
