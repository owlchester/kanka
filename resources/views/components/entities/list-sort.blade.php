@props(['columns', 'order'])
@php
    $sortOptions = collect($columns)
        ->filter(fn ($column) => !empty($column['sortable']) && !empty($column['label']))
        ->mapWithKeys(fn ($column) => [$column['sortKey'] ?? $column['key'] => $column['label']])
        ->merge(['created_at' => __('crud.fields.created_at'), 'updated_at' => __('crud.fields.updated_at')]);
    $sortField = array_key_first($order);
    $descending = $sortField && strtolower($order[$sortField]) === 'desc';
@endphp
<div class="mb-5 grid grid-cols-2 gap-3 border-b border-base-300 pb-5 md:hidden">
    <div class="field flex flex-col gap-1">
        <label for="mobile-list-order" class="text-xs font-medium">{{ __('datagrids.display.sort_by') }}</label>
        <select id="mobile-list-order" name="order" class="w-full">
            <option value="clear" @selected(!$sortField)>{{ __('campaigns/defaults.values.collapsed.default') }}</option>
            @foreach ($sortOptions as $key => $label)
                <option value="{{ $key }}" @selected($sortField === $key)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="field flex flex-col gap-1">
        <label for="mobile-list-direction" class="text-xs font-medium">{{ __('mobile.sort.direction') }}</label>
        <select id="mobile-list-direction" name="desc" class="w-full">
            <option value="0" @selected(!$descending)>{{ trim(__('crud.filters.sorting.asc', ['field' => ''])) }}</option>
            <option value="1" @selected($descending)>{{ trim(__('crud.filters.sorting.desc', ['field' => ''])) }}</option>
        </select>
    </div>
</div>
