@php
    $categoryStatuses = \App\Models\CategoryStatus::inCampaign($campaign)->where('category_id', $entityType->id)
        ->orderBy('sort_order')
        ->get();
    $currentValue = $filterService->filterValue($field);
    $currentValues = array_map('strval', is_array($currentValue) ? $currentValue : [$currentValue]);
@endphp
<select class="filter-select w-full entity-list-filter" id="{{ $field }}" name="{{ $field }}{{ is_array($currentValue) ? '[]' : '' }}" @if(is_array($currentValue)) multiple @endif>
    <option value=""></option>
    <option value="none" @selected(in_array('none', $currentValues, true))>{{ __('No status') }}</option>
    @foreach ($currentValues as $value)
        @if (str_starts_with($value, 'deleted:'))
            <option value="{{ $value }}" selected>{{ __('Deleted status — edit this filter') }}</option>
        @endif
    @endforeach
    @foreach ($categoryStatuses as $catStatus)
        <option value="{{ $catStatus->id }}" @selected(in_array((string) $catStatus->id, $currentValues, true))>
            {{ $catStatus->setRelation('entityType', $entityType)->name() }}
        </option>
    @endforeach
</select>
