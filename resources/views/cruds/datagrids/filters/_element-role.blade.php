<input type="text" class="w-full entity-list-filter" name="{{ $field }}" value="{{ $filterService->single($field) }}" autocomplete="off" list="entity-role-list" />
<div class="hidden">
    <datalist id="entity-role-list">
        @foreach (\App\Facades\QuestCache::campaign($campaign)->roleSuggestion() as $suggestion)
            <option value="{{ $suggestion }}">{{ $suggestion }}</option>
        @endforeach
    </datalist>
</div>
