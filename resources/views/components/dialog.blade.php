<dialog class="dialog rounded-2xl text-center" id="{{ $id }}" aria-modal="true" aria-labelledby="dialogLabel{{ $id }}">
    <header>
        <h4 id="dialogLabel{{ $id }}">
            {!! $title !!}
        </h4>
        <button type="button" class="rounded-full" onclick="this.closest('dialog').close('close')" title="{{ __('crud.delete_modal.close') }}">
            <i class="fa-solid fa-times" aria-hidden="true"></i>
            <span class="sr-only">{{ __('crud.delete_modal.close') }}</span>
        </button>
    </header>
    <article class="text-justify">
        {{ $slot }}
    </article>
</dialog>
