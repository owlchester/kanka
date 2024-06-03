<x-helper>{{ __('crud.helpers.copy_options') }}</x-helper>
<x-forms.field
    field="copy-posts">
    <input type="hidden" name="copy_source_notes" value="0" />
    <x-checkbox :text="__('crud.fields.copy_posts')">
        {!! Form::checkbox('copy_source_notes', 1, true) !!}
    </x-checkbox>
</x-forms.field>
<x-forms.field
    field="replace-mentions">
    <input type="hidden" name="replace_mentions" value="0" />
    <x-checkbox :text="__('crud.fields.replace_mentions')">
        {!! Form::checkbox('replace_mentions', 1, true) !!}
    </x-checkbox>
</x-forms.field>
<x-forms.field
    field="copy-abilities">
    <input type="hidden" name="copy_source_abilities" value="0" />
    <x-checkbox :text="__('crud.fields.copy_abilities')">
        {!! Form::checkbox('copy_source_abilities', 1, request()->filled('template')) !!}
    </x-checkbox>
</x-forms.field>
<x-forms.field
    field="copy-inventory">
    <input type="hidden" name="copy_source_inventory" value="0" />
    <x-checkbox :text="__('crud.fields.copy_inventory')">
        {!! Form::checkbox('copy_source_inventory', 1, request()->filled('template')) !!}
    </x-checkbox>
</x-forms.field>

<x-forms.field
    field="copy-permissions">
    <input type="hidden" name="copy_source_permissions" value="0" />
    <x-checkbox :text="__('crud.fields.copy_permissions')">
        {!! Form::checkbox('copy_source_permissions', 1, request()->filled('template')) !!}
    </x-checkbox>
</x-forms.field>
@if ($campaign->boosted())
    <x-forms.field
    field="copy-links">
        <input type="hidden" name="copy_source_links" value="0" />
        <x-checkbox :text="__('crud.fields.copy_links')">
            {!! Form::checkbox('copy_source_links', 1, request()->filled('template')) !!}
        </x-checkbox>
    </x-forms.field>
@endif

@if (view()->exists($name . '.form._copy'))
    @include($name . '.form._copy')
@endif
<input type="hidden" name="copy_source_id"
    value="{{ !empty($source) ? (!empty($source->entity) ? $source->entity->id : $source->id) : old('copy_source_id') }}">
