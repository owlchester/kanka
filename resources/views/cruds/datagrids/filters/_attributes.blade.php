<div class="col-md-6">
    <div class="form-group">
        <label>{{ __('entities/attributes.filters.name') }}</label>
        <input type="text" class="form-control entity-list-filter" name="attribute_name" value="{{ $filterService->single('attribute_name') }}" />
    </div>
</div>
<div class="col-md-6">
    <div class="form-group">
        <label>{{ __('entities/attributes.filters.value') }}</label>
        <input type="text" class="form-control entity-list-filter" name="attribute_value" value="{{ $filterService->single('attribute_value') }}" />
    </div>
</div>
