<div class="flex-none">
    <a
        href="#"
        data-url="{{ route('entity-creator.selection', $campaign) }}"
        data-toggle="dialog"
        class="quick-creator-button btn2 btn-default btn-sm"
        data-title="{{ __('header.qq.tooltip') }} [ N ]"
        data-tooltip
        tabindex="0">
        <x-icon class="flex-none fa-regular fa-plus" />
        <span class="grow hidden sm:inline-block">
            {{ __('crud.create') }}
        </span>
    </a>
</div>
