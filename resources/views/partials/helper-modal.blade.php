<dialog class="dialog rounded-2xl text-center" id="{{ $id }}" aria-modal="true" aria-labelledby="helpModalLabel{{ $id }}">
    <header>
        <h4 id="helpModalLabel{{ $id }}">
            {!! $title !!}
        </h4>
        <button type="button" class="rounded-full" onclick="this.closest('dialog').close('close')">
            <i class="fa-solid fa-times" aria-hidden="true"></i>
            <span class="sr-only">{{ __('crud.delete_modal.close') }}</span>
        </button>
    </header>
    <article>
        @foreach ($textes as $text)
            <p class="mb-1 text-justify">{!! $text !!}</p>
        @endforeach
    </article>
</dialog>
