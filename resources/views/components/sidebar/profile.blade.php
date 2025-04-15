<div class="sidebar-section-box sidebar-section-profile overflow-hidden flex flex-col gap-2">
    <div class="sidebar-section-title cursor-pointer group user-select border-b element-toggle" data-animate="collapse" data-target="#sidebar-profile-elements">
        <x-icon class="fa-solid fa-chevron-up icon-show transition-transform duration-200 group-hover:-translate-y-0.5" />
        <x-icon class="fa-solid fa-chevron-down icon-hide transition-transform duration-200 group-hover:translate-y-0.5" />
        <span class="text-lg">{{ __('crud.tabs.profile') }}</span>
    </div>

    <div class="sidebar-elements grid overflow-hidden" id="sidebar-profile-elements">
        <div class="flex flex-col gap-2">
            {!! $slot !!}
        </div>
    </div>
</div>
