@php
    $categoryStatuses = \App\Models\CategoryStatus::where('category_id', $entityType->id)
        ->orderBy('sort_order')
        ->get();
    $currentValue = $filterService->filterValue($field);
@endphp
<select class="filter-select w-full entity-list-filter" id="{{ $field }}" name="{{ $field }}">
    <option value=""></option>
    @foreach ($categoryStatuses as $catStatus)
        <option value="{{ $catStatus->id }}" @if ((string) $catStatus->id === $currentValue) selected="selected" @endif>
            {{ $catStatus->setRelation('entityType', $entityType)->name() }}
        </option>
    @endforeach
</select>
