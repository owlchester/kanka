<div class="sidebar-section-box sidebar-section-profile mb-5 overflow-hidden">
    <div class="sidebar-section-title cursor-pointer text-lg user-select border-b" data-toggle="collapse" data-target="#sidebar-profile-elements">
        <i class="fa-solid fa-chevron-right" style="display: none"></i>
        <i class="fa-solid fa-chevron-down"></i>
        {{ __('crud.tabs.profile') }}
    </div>

    <div class="sidebar-elements grid collapse !visible in overflow-hidden" id="sidebar-profile-elements">
        {!! $slot !!}
    </div>
</div>
