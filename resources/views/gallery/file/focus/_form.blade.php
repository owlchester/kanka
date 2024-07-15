
    <x-grid type="1/1">
        <p class="text-neutral-content">
            {{ __('entities/image.focus.helper') }}
        </p>
        <div class="focus-selector relative inline-block">
            <div class="focus absolute text-white drop-shadow cursor-pointer text-2xl @if(empty($image->focus_x)) hidden @else loading @endif" data-focus-x="{{ $image->focus_x }}" data-focus-y="{{ $image->focus_y }}">
                <x-icon class="fa-duotone fa-arrow-up-left-from-circle fa-2x hover:text-error" />
            </div>
            <img class="focus-image" src="{{ $image->getImagePath(0) }}" alt="img" />
        </div>
    </x-grid>
