@php
    $isDefault = !empty($row['is_default']);
    $rowId = $row['id'] ?? null;
    $usageCount = $rowId ? (int) (($statusCounts ?? [])[$rowId] ?? 0) : null;
@endphp
<div class="rounded-xl border border-base-300 bg-base-100 p-3 flex flex-col md:flex-row md:items-start gap-2 md:gap-3" data-status-row>
    <input type="hidden" data-status-field="id" name="statuses[{{ $index }}][id]" value="{{ $rowId ?? '' }}" />
    <input type="hidden" data-status-field="is_default" name="statuses[{{ $index }}][is_default]" value="{{ $isDefault ? 1 : 0 }}" />

    <button type="button" class="hidden md:inline-flex items-center justify-center size-9 shrink-0 cursor-grab active:cursor-grabbing text-neutral-content hover:text-base-content" data-status-handle aria-label="{{ __('Drag to reorder') }}" title="{{ __('Drag to reorder') }}">
        <x-icon class="fa-solid fa-grip-vertical" />
    </button>

    <div class="flex-1 min-w-0 flex flex-col gap-1">
        <input
            type="text"
            data-status-field="label"
            name="statuses[{{ $index }}][label]"
            value="{{ $row['label'] ?? $row['key'] ?? '' }}"
            maxlength="45"
            required
            placeholder="{{ __('Status label') }}"
            aria-label="{{ __('Label') }}"
            class="w-full"
        />
        @error("statuses.$index.label")
            <p class="text-xs text-error">{{ $message }}</p>
        @enderror
        <p class="text-xs text-error hidden" data-status-label-error>{{ __('Status labels must be unique within a category.') }}</p>
    </div>

    <div class="md:w-64 shrink-0 flex flex-col gap-1">
        <div class="flex items-center gap-2">
            <span class="size-9 shrink-0 rounded-lg border border-base-300 flex items-center justify-center" data-status-preview-box>
                <i data-status-preview aria-hidden="true"></i>
            </span>
            <input
                type="text"
                data-status-field="icon"
                name="statuses[{{ $index }}][icon]"
                value="{{ $row['icon'] ?? '' }}"
                maxlength="100"
                placeholder="{{ __('Icon (optional)') }}"
                aria-label="{{ __('Icon (optional)') }}"
                list="status-icon-list"
                autocomplete="off"
                data-paste="fontawesome"
                class="w-full"
            />
        </div>
        @error("statuses.$index.icon")
            <p class="text-xs text-error">{{ $message }}</p>
        @enderror
        <p class="text-xs text-error hidden" data-status-icon-error>{{ __('Enter a valid FontAwesome class (e.g. fa-solid fa-check).') }}</p>
    </div>

    <div class="flex items-center gap-1.5 shrink-0 md:pt-0.5 flex-wrap">
        <button
            type="button"
            data-status-default
            aria-pressed="{{ $isDefault ? 'true' : 'false' }}"
            class="btn2 btn-sm {{ $isDefault ? 'btn-primary' : 'btn-ghost' }}"
            title="{{ __('Default status for new entries') }}"
        >
            <i data-status-default-icon class="{{ $isDefault ? 'fa-solid fa-star' : 'fa-regular fa-star' }}" aria-hidden="true"></i>
            <span>{{ __('Default status') }}</span>
        </button>

        @if (!empty($rowId) && isset($entityType))
            <span class="badge badge-sm">
                {{ $usageCount > 0 ? trans_choice(':count entry|:count entries', $usageCount, ['count' => $usageCount]) : __('Unused') }}
            </span>
        @endif

        <button type="button" class="btn2 btn-ghost btn-sm btn-square" data-status-up aria-label="{{ __('Move up') }}" title="{{ __('Move up') }}">
            <x-icon class="fa-regular fa-arrow-up" />
        </button>
        <button type="button" class="btn2 btn-ghost btn-sm btn-square" data-status-down aria-label="{{ __('Move down') }}" title="{{ __('Move down') }}">
            <x-icon class="fa-regular fa-arrow-down" />
        </button>

        @if (!empty($rowId) && isset($entityType))
            <a
                class="btn2 btn-ghost btn-sm btn-square text-error hover:bg-error/10"
                href="{{ route('entity_types.statuses.confirm', [$campaign, $entityType, $rowId]) }}"
                aria-label="{{ __('Delete status') }}"
                title="{{ __('Delete status') }}"
            >
                <x-icon class="fa-regular fa-trash-can" />
            </a>
        @else
            <button
                type="button"
                class="btn2 btn-ghost btn-sm btn-square text-error hover:bg-error/10"
                data-status-remove
                aria-label="{{ __('Remove') }}"
                title="{{ __('Remove') }}"
            >
                <x-icon class="fa-regular fa-trash-can" />
            </button>
        @endif
    </div>
</div>
