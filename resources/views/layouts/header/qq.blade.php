<div class="hidden flex-none md:block">
    <a
        href="#"
        data-url="{{ route('entity-creator.selection', $campaign) }}"
        data-toggle="dialog"
        class="quick-creator-button group btn2 btn-outline flex-none h-9.5 min-h-9.5! px-3! text-neutral-content"
        data-shortcut="n"
        data-title="{{ __('header.qq.tooltip') }}"
        data-tooltip
        aria-label="{{ __('crud.create') }}"
        tabindex="0">
        <x-icon class="flex-none fa-regular fa-plus" />
        <span class="hidden md:inline">{{ __('crud.create') }}</span>
        <span class="hidden md:inline-flex items-center justify-center rounded bg-base-200 group-hover:bg-base-300 px-1.5 py-0.5 text-xs font-mono leading-none text-base-content/70 transition-colors" aria-hidden="true">N</span>
    </a>
</div>
