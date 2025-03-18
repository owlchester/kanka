<x-grid type="1/1">
    <x-helper>
        {{ __('entities/transform.panel.bulk_description') }}
    </x-helper>

    <x-forms.field field="target" :label="__('entities/transform.fields.target')">
        <x-forms.select name="target" :options="$entityTypes" class="w-full" required />
    </x-forms.field>
</x-grid>
