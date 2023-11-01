<input type="text" class="w-full entity-list-filter" name="{{ $field }}" value="{{ $filterService->single($field) }}" autocomplete="off" list="entity-type-list" />

<datalist id="entity-type-list">
    @foreach (\App\Facades\EntityCache::typeSuggestion($entityModel) as $suggestion)
        <option value="{{ $suggestion }}">{{ $suggestion }}</option>
    @endforeach
</datalist>
