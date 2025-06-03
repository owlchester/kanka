<div class="flex flex-col gap-4 md:gap-6 w-full" x-data="{open: false}">
    <span class="cursor-pointer text-sm border-dotted border-b w-full mt-4 md:mt-6" @click="open = !open">
        <x-icon class="fa-solid fa-caret-down" />
        {{ __('dashboard.widgets.tabs.advanced') }}
    </span>
    <div x-show="open" class="flex flex-col gap-4 md:gap-6">
        {!! $slot !!}
    </div>
</div>
