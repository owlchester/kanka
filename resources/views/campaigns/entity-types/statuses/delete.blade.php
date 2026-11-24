@extends('layouts.app', ['title' => __('Delete status'), 'mainTitle' => false, 'sidebar' => 'campaign'])

@section('content')
    <x-form :action="['entity_types.statuses.destroy', $campaign, $entityType, $status]" method="DELETE">
        <div class="bg-box rounded-xl p-6 flex flex-col gap-4 max-w-2xl">
            <h1 class="text-xl flex items-center gap-2">
                @if ($status->icon)
                    <i class="{{ $status->icon() }}" aria-hidden="true"></i>
                @endif
                <span>{{ __('Delete status') }}: {{ $status->name() }}</span>
            </h1>
            @include('partials.errors')

            @if ($count === 0)
                <p class="text-neutral-content">{{ __('No entries currently use this status.') }}</p>
                @if ($status->is_default)
                    <x-helper>
                        <p>{{ __('This is the default status. Deleting it will remove the default from this category.') }}</p>
                    </x-helper>
                @endif
            @else
                <p>{{ __('This affects :count entries, including deleted entries.', ['count' => $count]) }}</p>
                @if ($status->is_default)
                    <x-helper>
                        <p>{{ __('This is the default status. Its replacement becomes the default; clearing removes the default.') }}</p>
                    </x-helper>
                @endif

                @php
                    $defaultAction = ($statuses->isNotEmpty() && !old('clear')) ? 'replace' : 'clear';
                @endphp
                <div class="flex flex-col gap-3" data-status-delete-options>
                    @if ($statuses->isNotEmpty())
                        <label class="rounded-xl border border-base-300 bg-base-100 p-4 flex gap-3 items-start cursor-pointer hover:shadow-sm">
                            <input type="radio" name="delete_action" value="replace" class="mt-1" @checked($defaultAction === 'replace') />
                            <div class="flex-1 flex flex-col gap-2">
                                <span class="font-medium">{{ __('Reassign entries to another status') }}</span>
                                <select name="replacement_id" class="w-full" required>
                                    @foreach ($statuses as $replacement)
                                        <option value="{{ $replacement->id }}" @selected((string) old('replacement_id') === (string) $replacement->id)>{{ $replacement->name() }}</option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-neutral-content">{{ __('Replacement also updates saved bookmark and widget filters.') }}</p>
                            </div>
                        </label>
                    @endif

                    <label class="rounded-xl border border-base-300 bg-base-100 p-4 flex gap-3 items-start cursor-pointer hover:shadow-sm">
                        <input type="radio" name="delete_action" value="clear" class="mt-1" @checked($defaultAction === 'clear') />
                        <div class="flex-1 flex flex-col gap-1">
                            <span class="font-medium">{{ __('Clear status from entries') }}</span>
                            <input type="hidden" name="clear" value="1" />
                            <p class="text-xs text-neutral-content">{{ __('Clearing leaves affected bookmark and widget filters nonmatching until edited; it never broadens a list.') }}</p>
                        </div>
                    </label>
                </div>

                <script>
                    (() => {
                        const container = document.querySelector('[data-status-delete-options]');
                        if (!container) return;
                        const sync = () => {
                            const selected = container.querySelector('input[name="delete_action"]:checked')?.value;
                            const replacement = container.querySelector('select[name="replacement_id"]');
                            const clear = container.querySelector('input[name="clear"]');
                            if (replacement) replacement.disabled = selected !== 'replace';
                            if (clear) clear.disabled = selected !== 'clear';
                        };
                        container.addEventListener('change', sync);
                        sync();
                    })();
                </script>
            @endif

            <div class="flex gap-3 pt-2">
                <a href="{{ route('entity_types.edit', [$campaign, $entityType]) }}#category-statuses" class="btn2">{{ __('crud.cancel') }}</a>
                <button type="submit" class="btn2 btn-error">{{ __('Delete status') }}</button>
            </div>
        </div>
    </x-form>
@endsection
