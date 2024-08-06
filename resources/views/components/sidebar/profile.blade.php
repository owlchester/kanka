<div class="sidebar-section-box sidebar-section-profile overflow-hidden flex flex-col gap-2">
    <div class="sidebar-section-title cursor-pointer text-lg user-select border-b element-toggle" data-animate="collapse" data-target="#sidebar-profile-elements">
        <x-icon class="fa-solid fa-chevron-up icon-show" />
        <x-icon class="fa-solid fa-chevron-down icon-hide" />
        {{ __('crud.tabs.profile') }}
    </div>

    <div class="sidebar-elements grid overflow-hidden" id="sidebar-profile-elements">
        <div class="flex flex-col gap-2">
            {!! $slot !!}
        </div>
    </div>
</div>
