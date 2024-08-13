<x-forms.field field="destroyed" :label="__('locations.fields.is_destroyed')">
    <input type="hidden" name="is_destroyed" value="0" />
    <x-checkbox :text="__('locations.hints.is_destroyed')">
        <input type="checkbox" name="is_destroyed" value="1" @if (old('is_destroyed', $model->is_destroyed ?? false)) checked="checked" @endif />
    </x-checkbox>
</x-forms.field>
