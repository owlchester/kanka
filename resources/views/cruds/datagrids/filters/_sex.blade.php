<input type="text" class="form-control entity-list-filter" name="{{ $field }}" value="{{ $filterService->single($field) }}" autocomplete="off" list="entity-gender-list" />
<div class="hidden">
    <datalist id="entity-gender-list">
        @foreach (\App\Facades\CharacterCache::genderSuggestion() as $suggestion)
            <option value="{{ $suggestion }}">{{ $suggestion }}</option>
        @endforeach
    </datalist>
</div>
