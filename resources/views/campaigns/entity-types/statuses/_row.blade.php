<div class="border border-base-300 rounded-xl p-4 flex flex-col gap-3" data-status-row draggable="true">
    <input type="hidden" data-status-field="id" name="statuses[{{ $index }}][id]" value="{{ $row['id'] ?? '' }}" />
    <input type="hidden" data-status-field="is_default" name="statuses[{{ $index }}][is_default]" value="{{ !empty($row['is_default']) ? 1 : 0 }}" />
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <label class="flex flex-col gap-1">
            <span class="text-xs font-medium opacity-80">{{ __('Label') }}</span>
            <input data-status-field="label" name="statuses[{{ $index }}][label]" value="{{ $row['label'] ?? $row['key'] ?? '' }}" maxlength="45" required class="w-full" />
        </label>
        <label class="flex flex-col gap-1">
            <span class="text-xs font-medium opacity-80">{{ __('Icon (optional)') }}</span>
            <span class="flex items-center gap-2">
                <input data-status-field="icon" name="statuses[{{ $index }}][icon]" value="{{ $row['icon'] ?? '' }}" maxlength="100" placeholder="fa-solid fa-magnifying-glass" class="w-full" />
                <i data-status-preview aria-hidden="true"></i>
            </span>
        </label>
    </div>
    <div class="flex flex-wrap gap-3 items-center">
        <label class="flex gap-2 items-center"><input type="radio" name="status_default" data-status-default @checked(!empty($row['is_default'])) />{{ __('Default status') }}</label>
        <button type="button" class="btn2 btn-outline btn-sm" data-status-up aria-label="{{ __('Move up') }}"><x-icon class="fa-regular fa-arrow-up" /></button>
        <button type="button" class="btn2 btn-outline btn-sm" data-status-down aria-label="{{ __('Move down') }}"><x-icon class="fa-regular fa-arrow-down" /></button>
        <span class="grow"></span>
        @if (!empty($row['id']) && isset($entityType))
            <a class="text-error hover:text-error-content focus:text-error-content" href="{{ route('entity_types.statuses.confirm', [$campaign, $entityType, $row['id']]) }}">{{ __('Delete status') }}</a>
        @else
            <button type="button" class="btn2 btn-outline btn-sm text-error hover:text-error-content focus:text-error-content" data-status-remove>{{ __('Remove') }}</button>
        @endif
    </div>
</div>
