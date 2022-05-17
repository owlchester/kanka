<dialog class="dialog rounded-2xl text-center" id="{{ $id }}">
    <header>
        <h4 id="myModalLabel">
            {!! $title !!}
        </h4>
        <button type="button" class="rounded-full" onclick="this.closest('dialog').close('close')">
            <i class="fa-solid fa-times" aria-hidden="true"></i>
        </button>
    </header>
    <article>
        @foreach ($textes as $text)
            <p class="mb-2 text-justify">{!! $text !!}</p>
        @endforeach
    </article>
</dialog>
