<input type="text" class="form-control entity-list-filter" name="{{ $field }}" value="{{ $filterService->single($field) }}" autocomplete="off" list="entity-type-list" />
<div class="hidden">
    <datalist id="entity-type-list">
        @foreach (\App\Facades\EntityCache::typeSuggestion($entityModel) as $suggestion)
            <option value="{{ $suggestion }}">{{ $suggestion }}</option>
        @endforeach
    </datalist>
</div>
