<x-forms.field
    field="closed"
    :label="__('crud.fields.closed')">
    <input type="hidden" name="is_closed" value="0" />
    <x-checkbox :text="__('crud.fields.is_closed')">
        <input type="checkbox" name="is_closed" value="1" @if (old('is_closed', $source->child->is_closed ?? $model->is_closed ?? false)) checked="checked" @endif />
    </x-checkbox>
</x-forms.field>
