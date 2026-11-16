<div class="flex-none">
    <a
        href="#"
        data-url="{{ route('entity-creator.selection', $campaign) }}"
        data-toggle="dialog"
        class="quick-creator-button btn2 btn-default btn-sm max-md:size-11! max-md:min-w-11 max-md:min-h-11! max-md:p-1!"
        data-shortcut="n"
        data-title="{{ __('header.qq.tooltip') }} [ N ]"
        data-tooltip
        aria-label="{{ __('crud.create') }}"
        tabindex="0">
        <x-icon class="flex-none fa-regular fa-plus" />
        <span class="grow hidden md:inline-block">
            {{ __('crud.create') }}
        </span>
    </a>
</div>
