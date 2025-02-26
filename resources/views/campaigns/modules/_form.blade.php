<x-grid type="1/1">
    <p class="m-0 text-justify">{{ __('campaigns/modules.rename.helper') }}</p>

    <x-forms.field
        field="singular"
        :label="__('campaigns/modules.fields.singular')">
        <input type="text" name="singular" value="{!! old('singular', $singular) !!}" maxlength="45" class="w-full" placeholder="{{ $entityType->name() }}" />
    </x-forms.field>

    <x-forms.field
        field="plural"
        :label="__('campaigns/modules.fields.plural')">
        <input type="text" name="plural" value="{!! old('plural', $plural) !!}" maxlength="45" class="w-full" placeholder="{{ $entityType->plural() }}" />
    </x-forms.field>

    <x-forms.field
        field="icon"
        :label="__('campaigns/modules.fields.icon')"
        :helper="__('campaigns/modules.helpers.icon', [
        'fontawesome' => '<a href=\'' . config('fontawesome.search') . '\'>FontAwesome</a>',
        'example' => '<i class=\'fa-solid fa-horse\' aria-hidden=\'true\'></i> <code>fa-solid fa-horse</code>',
        ])">
        <input type="text" name="icon" value="{{ old('icon', $icon) }}" maxlength="60" class="w-full" list="module-icon-list" placeholder="{{ $entityType->icon() }}" />
    </x-forms.field>
</x-grid>
