<input type="text" class="w-full entity-list-filter" name="{{ $field }}" value="{{ $filterService->single($field) }}" autocomplete="off" list="entity-gender-list" />

<datalist id="entity-gender-list">
    @foreach (app(\App\Services\Caches\SuggestionCache::class)->characterGenders($campaign) as $suggestion)
        <option value="{{ $suggestion }}">{{ $suggestion }}</option>
    @endforeach
</datalist>

