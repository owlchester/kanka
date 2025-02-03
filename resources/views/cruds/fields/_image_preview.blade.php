<div class="preview-v2">
    <div class="image rounded h-28 cover-background relative w-full flex items-end " style="background-image: url('{{ $image }}')" aria-title="{{ $title }}">
        @if (isset($target) && !empty($target))
        <a href="#" data-img="delete" class="text-center block rounded w-full p-2 overflow-hidden m-1 text-white hover:bg-error backdrop-blur-sm duration-150 transition-opacity truncate" data-target="{{ $target }}" data-tooltip data-title="{{ __('crud.remove') }}" aria-label="{{ __('crud.remove') }}">
            <x-icon class="trash" /> {{ __('crud.remove') }}
        </a>
        @endif
    </div>
</div>
