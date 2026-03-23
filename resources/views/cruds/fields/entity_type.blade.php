<x-forms.field field="entity-type" :label="__('attribute_templates.fields.auto_apply')">
    <select name="entity_type_id" class="w-full">
        <option value=""></option>
        @if (isset($bulk) && $bulk)
            <option value="0">{{ __('attribute_templates.bulk.entity_type.unset') }}</option>
        @endif
        @foreach (\App\Models\EntityType::inCampaign($campaign)->where('code', '<>', 'bookmark')->orderBy('code')->get() as $option)
            <option value="{{ $option->id }}">{{ $option->name() }}</option>
        @endforeach
    </select>
</x-forms.field>
