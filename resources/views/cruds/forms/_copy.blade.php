<x-helper>{{ __('crud.helpers.copy_options') }}</x-helper>
<x-forms.field
    field="copy-posts">
    {!! Form::hidden('copy_source_notes', null) !!}
    <x-checkbox :text="__('crud.fields.copy_posts')">
        {!! Form::checkbox('copy_source_notes', 1, true) !!}
    </x-checkbox>
</x-forms.field>
<x-forms.field
    field="replace-mentions">
    {!! Form::hidden('replace_mentions', null) !!}
    <x-checkbox :text="__('crud.fields.replace_mentions')">
        {!! Form::checkbox('replace_mentions', 1, true) !!}
    </x-checkbox>
</x-forms.field>
<x-forms.field
    field="copy-abilities">
    {!! Form::hidden('copy_source_abilities', null) !!}
    <x-checkbox :text="__('crud.fields.copy_abilities')">
        {!! Form::checkbox('copy_source_abilities', 1, request()->filled('template')) !!}
    </x-checkbox>
</x-forms.field>
<x-forms.field
    field="copy-inventory">
    {!! Form::hidden('copy_source_inventory', null) !!}
    <x-checkbox :text="__('crud.fields.copy_inventory')">
        {!! Form::checkbox('copy_source_inventory', 1, request()->filled('template')) !!}
    </x-checkbox>
</x-forms.field>

<x-forms.field
    field="copy-permissions">
    {!! Form::hidden('copy_source_permissions', null) !!}
    <x-checkbox :text="__('crud.fields.copy_permissions')">
        {!! Form::checkbox('copy_source_permissions', 1, request()->filled('template')) !!}
    </x-checkbox>
</x-forms.field>
@if ($campaign->boosted())
    <x-forms.field
    field="copy-links">
        {!! Form::hidden('copy_source_links', null) !!}

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
