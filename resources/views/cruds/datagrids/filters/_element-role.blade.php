<input type="text" class="form-control entity-list-filter" name="{{ $field }}" value="{{ $filterService->single($field) }}" autocomplete="off" list="entity-role-list" />
<div class="hidden">
    <datalist id="entity-role-list">
        @foreach (\App\Facades\QuestCache::roleSuggestion() as $suggestion)
            <option value="{{ $suggestion }}">{{ $suggestion }}</option>
        @endforeach
    </datalist>
</div>
