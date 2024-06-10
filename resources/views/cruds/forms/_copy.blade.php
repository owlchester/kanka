<x-helper>{{ __('crud.helpers.copy_options') }}</x-helper>
<x-forms.field
    field="copy-posts">
    <input type="hidden" name="copy_source_notes" value="0" />
    <x-checkbox :text="__('crud.fields.copy_posts')">
        <input type="checkbox" name="copy_source_notes" value="1" @if (old('copy_source_notes', true)) checked="checked" @endif />
    </x-checkbox>
</x-forms.field>
<x-forms.field
    field="replace-mentions">
    <input type="hidden" name="replace_mentions" value="0" />
    <x-checkbox :text="__('crud.fields.replace_mentions')">
        <input type="checkbox" name="replace_mentions" value="1" @if (old('replace_mentions', true)) checked="checked" @endif />
    </x-checkbox>
</x-forms.field>
<x-forms.field
    field="copy-abilities">
    <input type="hidden" name="copy_source_abilities" value="0" />
    <x-checkbox :text="__('crud.fields.copy_abilities')">
        <input type="checkbox" name="copy_source_abilities" value="1" @if (old('copy_source_abilities', request()->filled('template'))) checked="checked" @endif />
    </x-checkbox>
</x-forms.field>
<x-forms.field
    field="copy-inventory">
    <input type="hidden" name="copy_source_inventory" value="0" />
    <x-checkbox :text="__('crud.fields.copy_inventory')">
        <input type="checkbox" name="copy_source_inventory" value="1" @if (old('copy_source_inventory', request()->filled('template'))) checked="checked" @endif />
    </x-checkbox>
</x-forms.field>

<x-forms.field
    field="copy-permissions">
    <input type="hidden" name="copy_source_permissions" value="0" />
    <x-checkbox :text="__('crud.fields.copy_permissions')">
        <input type="checkbox" name="copy_source_permissions" value="1" @if (old('copy_source_permissions', request()->filled('template'))) checked="checked" @endif />
    </x-checkbox>
</x-forms.field>
@if ($campaign->boosted())
    <x-forms.field
    field="copy-links">
        <input type="hidden" name="copy_source_links" value="0" />
        <x-checkbox :text="__('crud.fields.copy_links')">
            <input type="checkbox" name="copy_source_links" value="1" @if (old('copy_source_links', request()->filled('template'))) checked="checked" @endif />
        </x-checkbox>
    </x-forms.field>
@endif

@if (view()->exists($name . '.form._copy'))
    @include($name . '.form._copy')
@endif
<input type="hidden" name="copy_source_id"
    value="{{ !empty($source) ? (!empty($source->entity) ? $source->entity->id : $source->id) : old('copy_source_id') }}">
