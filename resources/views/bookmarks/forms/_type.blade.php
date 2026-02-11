@inject('entityTypeService', 'App\Services\EntityTypeService')
@php
/** @var \App\Services\EntityTypeService $entityTypeService */
$entityTypes = $entityTypeService->campaign($campaign)->exclude([config('entities.ids.bookmark')])->prepend(['' => ''])->toSelect();
@endphp
<x-grid type="1/1">

    <x-helper>
        <p>
        {!! __('bookmarks.helpers.type', [
            'filter' => '<span class="text-extrabold">' . __('bookmarks.fields.filters') . '</span>',
            '?' => '<code>?</code>',
        ]) !!}
        </p>
    </x-helper>

    <x-grid>
        <x-forms.field field="entity_type_id" :label="__('campaigns/categories.tab')">
            <x-forms.select name="entity_type_id" :options="$entityTypes" :selected="$source->entity_type_id ?? $model->entity_type_id ?? null" />
        </x-forms.field>

        <x-forms.field field="filters" :label="__('bookmarks.fields.filters')">
            <input type="text" name="filters" value="{{ old('filters', $source->filters ?? $model->filters ?? null) }}" placeholder="{{ __('bookmarks.placeholders.filters') }}" maxlength="191" />
        </x-forms.field>
    </x-grid>
</x-grid>
