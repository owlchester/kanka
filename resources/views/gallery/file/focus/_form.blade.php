<x-grid type="1/1">
    <p class="text-neutral-content m-0">
        {{ __('entities/image.focus.helper') }}
    </p>
    <div class="focus-selector max-h-96 relative mb-2 overflow-auto">
        <div class="focus absolute text-white cursor-pointer text-3xl" style="@if(empty($image->focus_x))display: none; @else left: {{ $image->focus_x }}px; top: {{ $image->focus_y }}px; @endif">
            <x-icon class="fa-regular fa-bullseye fa-2x hover:text-error" />
        </div>
        <img class="focus-image max-w-none" src="{{ $image->getImagePath(0) }}" alt="img" />
    </div>
</x-grid>
