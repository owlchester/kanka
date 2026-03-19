@if (isset($bulk) && $bulk)
    <div class="grid gap-2 md:gap-4 grid-cols-2">
@endif

<x-forms.field field="entity-type" :label="__('attribute_templates.fields.auto_apply')">
    <select name="entity_type_id" class="w-full">
        <option value=""></option>
        @foreach (\App\Models\EntityType::inCampaign($campaign)->where('code', '<>', 'bookmark')->orderBy('code')->get() as $option)
            <option value="{{ $option->id }}">{{ $option->name() }}</option>
        @endforeach
    </select>
</x-forms.field>

@if (isset($bulk) && $bulk)
    <x-forms.field field="bulk-entity-type" :label="__('attribute_templates.bulk.entity_type.action')">
        <label class="flex items-center gap-2">
            <input type="checkbox" name="bulk-entity-type" value="remove" />
            {{ __('attribute_templates.bulk.entity_type.remove') }}
        </label>
    </x-forms.field>
    </div>
@endif
