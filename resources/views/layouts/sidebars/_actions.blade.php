@if (!empty($campaign))
    <div class="hidden md:flex items-center gap-2 flex-none">
        <button
            type="button"
            data-sidebar-action="search"
            data-tooltip
            data-html="true"
            data-title="{{ __('crud.keyboard-shortcut', ['code' => '<code>K</code>']) }}"
            aria-label="{{ __('crud.search') }}"
            class="flex-1 min-w-0 h-10 px-3 bg-base-100 hover:bg-base-200 rounded-[var(--sidebar-radius)] flex items-center gap-2 text-sm text-base-content/75 hover:text-base-content transition-colors cursor-pointer"
        >
            <x-icon class="fa-solid fa-magnifying-glass flex-none text-xs" />
            <span class="grow truncate text-left">{{ __('crud.search') }}</span>
            <span class="inline-flex items-center justify-center rounded bg-base-200 px-1.5 py-0.5 text-xs font-mono leading-none text-base-content/70" aria-hidden="true">K</span>
        </button>

        @if (auth()->check() && auth()->user()->can('member', $campaign) && (!isset($qq) || $qq))
            <a
                href="#"
                data-url="{{ route('entity-creator.selection', $campaign) }}"
                data-toggle="dialog"
                data-tooltip
                data-title="{{ __('header.qq.tooltip') }}"
                aria-label="{{ __('crud.create') }}"
                class="flex-none size-10 bg-base-100 hover:bg-primary hover:text-primary-content text-base-content rounded-[var(--sidebar-radius)] inline-flex items-center justify-center transition-colors"
            >
                <x-icon class="fa-regular fa-plus" />
            </a>
        @endif
    </div>
@endif
