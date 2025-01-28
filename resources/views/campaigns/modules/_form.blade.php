<x-grid type="1/1">
    <p class="m-0 text-justify">{{ __('campaigns/modules.rename.helper') }}</p>

    <x-forms.field
        field="singular"
        :label="__('campaigns/modules.fields.singular')">
        <input type="text" name="singular" value="{!! old('singular', $singular) !!}" maxlength="45" class="w-full" placeholder="{{ __('entities.' . $entityType->code) }}" />
    </x-forms.field>

    <x-forms.field
        field="plural"
        :label="__('campaigns/modules.fields.plural')">
        <input type="text" name="plural" value="{!! old('plural', $plural) !!}" maxlength="45" class="w-full" placeholder="{{ __('entities.' . \Illuminate\Support\Str::plural($entityType->code)) }}" />
    </x-forms.field>

    <x-forms.field
        field="icon"
        :label="__('campaigns/modules.fields.icon')">
        <input type="text" name="icon" value="{{ old('icon', $icon) }}" maxlength="40" class="w-full" />
    </x-forms.field>
</x-grid>
