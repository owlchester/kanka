<x-forms.field
    field="copy-posts">
    <input type="hidden" name="copy_elements" />
    <x-checkbox :text="__('quests.fields.copy_elements')">
        <input type="checkbox" name="copy_elements" value="1" checked="checked" />
    </x-checkbox>
</x-forms.field>
