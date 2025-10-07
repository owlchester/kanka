<select class="filter-select w-full entity-list-filter" id="{{ $field }}" name="{{ $field }}">
    <option value=""></option>
    <option value="1"  @if ($filterService->filterValue($field) === '1') selected="selected" @endif>{{ __('crud.filters.options.show') }}</option>
</select>
