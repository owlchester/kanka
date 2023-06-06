
<div class="grid grid-cols-2 gap-2 md:gap-5">
    <div class="field-filter-name">
        <label>{{ __('entities/attributes.filters.name') }}</label>
        <input type="text" class="form-control entity-list-filter" name="attribute_name" value="{{ $filterService->single('attribute_name') }}" />
    </div>

    <div class="field-filter-value">
        <label>{{ __('entities/attributes.filters.value') }}</label>
        <input type="text" class="form-control entity-list-filter" name="attribute_value" value="{{ $filterService->single('attribute_value') }}" />
    </div>
</div>

