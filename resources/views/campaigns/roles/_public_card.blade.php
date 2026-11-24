@props([
    'campaign',
    'role',
    'entityType',
    'enabled' => false,
    'isDisabled' => false,
])
<button
    type="button"
    role="switch"
    aria-checked="{{ $enabled ? 'true' : 'false' }}"
    data-url="{{ route('campaign_roles.toggle', [$campaign, $role, 'entityType' => $entityType, 'action' => \App\Enums\Permission::View->value]) }}"
    data-entity-type-id="{{ $entityType->id }}"
    data-active-category="{{ $isDisabled ? '0' : '1' }}"
    class="public-permission group bg-base-100 hover:bg-base-200/60 rounded-xl p-3.5 shadow-xs flex items-center justify-between gap-3 text-left cursor-pointer transition-all ring-1 ring-transparent aria-checked:ring-primary/40 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-primary disabled:opacity-60 disabled:cursor-wait {{ $isDisabled ? 'opacity-75' : '' }}"
>
    <span class="flex items-center gap-3 min-w-0">
        <span class="w-10 h-10 rounded-lg shrink-0 flex items-center justify-center text-lg transition-colors bg-base-200 text-neutral-content group-aria-checked:bg-primary/15 group-aria-checked:text-primary">
            <span class="module-icon">
                <x-icon class="{{ $entityType->icon() }}" />
            </span>
            <span class="loading-animation hidden">
                <x-icon class="load" />
            </span>
        </span>
        <span class="min-w-0">
            <span class="block font-medium truncate text-base-content">{!! $entityType->plural() !!}</span>
            <span class="hidden group-aria-checked:block text-xs text-primary font-medium">
                {{ __('campaigns/roles.public.status.visible') }}
            </span>
            <span class="block group-aria-checked:hidden text-xs text-neutral-content">
                {{ __('campaigns/roles.public.status.hidden') }}
            </span>
        </span>
    </span>

    <span aria-hidden="true" class="relative inline-flex h-6 w-11 shrink-0 items-center rounded-full bg-base-300 transition-colors group-aria-checked:bg-primary">
        <span class="inline-block h-4 w-4 translate-x-1 rounded-full bg-base-100 shadow-xs transition-transform group-aria-checked:translate-x-6"></span>
    </span>
</button>
