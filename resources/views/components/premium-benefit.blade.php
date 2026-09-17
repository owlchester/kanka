@props([
    'icon',
    'title',
    'subtitle' => null,
    'iconBg' => 'bg-blue-100',
    'iconText' => 'text-blue-600',
])

<div class="flex gap-4 items-center">
    <div class="h-11 w-11 flex-none text-center rounded-xl flex items-center justify-center {{ $iconBg }}">
        <x-icon class="fa-regular {{ $icon }} {{ $iconText }} text-lg" />
    </div>
    <div class="flex flex-col">
        <p class="font-semibold">
            {{ $title }}
        </p>
        @if ($subtitle)
            <p class="text-neutral-content text-xs">
                {{ $subtitle }}
            </p>
        @endif
    </div>
</div>
