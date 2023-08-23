<dialog class="dialog rounded-top md:rounded-2xl bg-base-100 min-w-fit shadow-md text-base-content" id="{{ $id }}" aria-modal="true" aria-labelledby="dialogLabel{{ $id }}">
    <header class="bg-base-200">
        <h4 id="dialogLabel{{ $id }}">
            @if ($loading)
                {{ __('Loading') }}
            @else
                {!! $title !!}
            @endif
        </h4>
        <button type="button" class="rounded-full bg-base-300" onclick="this.closest('dialog').close('close')" title="{{ __('crud.delete_modal.close') }}">
            <i class="fa-solid fa-times" aria-hidden="true"></i>
            <span class="sr-only">{{ __('crud.delete_modal.close') }}</span>
        </button>
    </header>
    <article class="text-justify @if (!$full) max-w-2xl @endif">
        @if ($loading)
            <div class="p-5 text-center w-full text-lg">
                <x-icon class="load" />
            </div>
        @endif
        {{ $slot }}
    </article>
    @if (isset($footer))
        <footer class="bg-base-200 flex flex-wrap gap-3 justify-between items-start p-3">
        @include($footer)
        </footer>
    @endif
</dialog>
