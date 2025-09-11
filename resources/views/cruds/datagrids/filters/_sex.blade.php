<input type="text" class="w-full entity-list-filter" name="{{ $field }}" value="{{ $filterService->single($field) }}" autocomplete="off" list="entity-gender-list" />

<datalist id="entity-gender-list">
    @foreach (\App\Facades\CharacterCache::campaign($campaign)->genderSuggestion() as $suggestion)
        <option value="{{ $suggestion }}">{{ $suggestion }}</option>
    @endforeach
</datalist>

