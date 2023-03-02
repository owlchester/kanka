<div class="preview-v2">
    <div class="image rounded h-28 cover-background relative inline-block w-full" style="background-image: url('{{ $image }}')" title="{{ $title }}">
        @if (isset($target) && !empty($target))
        <a href="#" class="img-delete text-center absolute bottom-0 block w-full p-2 overflow-hidden" data-target="{{ $target }}" title="{{ __('crud.remove') }}">
            <i class="fa-solid fa-trash"></i> {{ __('crud.remove') }}
        </a>
        @endif
    </div>
</div>
