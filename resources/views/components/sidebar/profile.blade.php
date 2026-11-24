<div class="sidebar-section-box sidebar-section-profile overflow-hidden flex flex-col gap-2">
    <button type="button" class="sidebar-section-title text-left cursor-pointer group user-select element-toggle flex items-center justify-between gap-2 w-full" data-animate="collapse" data-target="#sidebar-profile-elements" aria-expanded="true" aria-controls="sidebar-profile-elements">
        <span class="text-xs font-semibold uppercase tracking-wider">{{ __('crud.tabs.profile') }}</span>
        <span class="text-xs shrink-0">
            <x-icon class="fa-regular fa-chevron-up icon-show transition-transform duration-200 group-hover:-translate-y-0.5" />
            <x-icon class="fa-regular fa-chevron-down icon-hide transition-transform duration-200 group-hover:translate-y-0.5" />
        </span>
    </button>

    <div class="sidebar-elements grid overflow-hidden" id="sidebar-profile-elements">
        <div class="flex flex-col gap-2">
            {!! $slot !!}
        </div>
    </div>
</div>
