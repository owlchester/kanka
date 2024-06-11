@inject('typeService', 'App\Services\Entity\TypeService')
@php
$entityTypes = $typeService->campaign($campaign)->plural()->permissionless()->exclude(['bookmark'])->singularKey()->add(['' => ''])->get();
@endphp
<x-grid type="1/1">

    <x-helper>
        {!! __('bookmarks.helpers.type', [
            'filter' => '<code>' . __('bookmarks.fields.filters') . '</code>',
            '?' => '<code>?</code>',
        ]) !!}
    </x-helper>

    <x-grid>
        <x-forms.field field="type" :label="__('crud.fields.type')">
            <x-forms.select name="type" :options="$entityTypes" :selected="$source->type ?? $model->type ?? null" />
        </x-forms.field>

        <x-forms.field field="filters" :label="__('bookmarks.fields.filters')">
            <input type="text" name="filters" value="{{ old('filters', $source->filters ?? $model->filters ?? null) }}" placeholder="{{ __('bookmarks.placeholders.filters') }}" maxlength="191" />
        </x-forms.field>
    </x-grid>
</x-grid>
