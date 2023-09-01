<x-helper>{{ __('crud.helpers.copy_options') }}</x-helper>
<x-forms.field
    field="copy-posts">
    {!! Form::hidden('copy_source_notes', null) !!}
    <label>{!! Form::checkbox('copy_source_notes', 1, true) !!}
        {{ __('crud.fields.copy_posts') }}
    </label>
</x-forms.field>
<x-forms.field
    field="replace-mentions">
    {!! Form::hidden('replace_mentions', null) !!}
    <label>{!! Form::checkbox('replace_mentions', 1, true) !!}
        {{ __('crud.fields.replace_mentions') }}
    </label>
</x-forms.field>
<x-forms.field
    field="copy-abilities">
    {!! Form::hidden('copy_source_abilities', null) !!}
    <label>{!! Form::checkbox('copy_source_abilities', 1, request()->filled('template')) !!}
        {{ __('crud.fields.copy_abilities') }}
    </label>
</x-forms.field>
<x-forms.field
    field="copy-inventory">
    {!! Form::hidden('copy_source_inventory', null) !!}
    <label>{!! Form::checkbox('copy_source_inventory', 1, request()->filled('template')) !!}
        {{ __('crud.fields.copy_inventory') }}
    </label>
</x-forms.field>

<x-forms.field
    field="copy-permissions">
    {!! Form::hidden('copy_source_permissions', null) !!}
    <label>{!! Form::checkbox('copy_source_permissions', 1, request()->filled('template')) !!}
        {{ __('crud.fields.copy_permissions') }}
    </label>
</x-forms.field>
@if ($campaign->boosted())
    <x-forms.field
    field="copy-links">
        {!! Form::hidden('copy_source_links', null) !!}
        <label>{!! Form::checkbox('copy_source_links', 1, request()->filled('template')) !!}
            {{ __('crud.fields.copy_links') }}
        </label>
    </x-forms.field>
@endif

@if (view()->exists($name . '.form._copy'))
    @include($name . '.form._copy')
@endif
<input type="hidden" name="copy_source_id"
    value="{{ !empty($source) ? (!empty($source->entity) ? $source->entity->id : $source->id) : old('copy_source_id') }}">
