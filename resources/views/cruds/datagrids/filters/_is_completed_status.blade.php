<select class="filter-select w-full entity-list-filter" id="{{ $field }}" name="{{ $field }}">
    <option value=""></option>
    <option value="0" @if ($filterService->filterValue($field) === '0') selected="selected" @endif>{{ __('quests.status.not_started') }}</option>
    <option value="1" @if ($filterService->filterValue($field) === '1') selected="selected" @endif>{{ __('quests.status.ongoing') }}</option>
    <option value="2" @if ($filterService->filterValue($field) === '2') selected="selected" @endif>{{ __('quests.status.completed') }}</option>
    <option value="3" @if ($filterService->filterValue($field) === '3') selected="selected" @endif>{{ __('quests.status.abandoned') }}</option>
</select>
