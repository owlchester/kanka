<div class="flex flex-col gap-4 md:gap-6 w-full">
    <span class="cursor-pointer text-sm border-dotted border-b w-full mt-4 md:mt-6" data-animate="collapse" data-target="#widget-advanced-more">
        <x-icon class="fa-solid fa-caret-down" />
        {{ __('dashboard.widgets.tabs.advanced') }}
    </span>
    <div class="hidden flex flex-col gap-4 md:gap-6" id="widget-advanced-more">
        {!! $slot !!}
    </div>
</div>
