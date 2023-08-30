<dialog class="dialog rounded-top md:rounded-2xl bg-base-100 min-w-fit shadow-md text-base-content" id="{{ $id }}" aria-modal="true" aria-labelledby="dialogLabel{{ $id }}" @if (!$dismissible) data-dismissible="false" @endif>
    <x-dialog.header :id="$id">
        @if ($loading)
            {{ __('Loading') }}
        @else
            {!! $title !!}
        @endif
    </x-dialog.header>
    @if (isset($form)) {!! Form::open($form) !!} @endif
    <article class="text-justify @if (!$full) max-w-2xl @endif">
        @if ($loading)
            <div class="p-5 text-center w-full text-lg">
                <x-icon class="load" />
            </div>
        @endif
        {{ $slot }}
    </article>
    @if (isset($footer))
        <footer class="bg-base-200 flex flex-wrap gap-3 justify-between items-start p-3 rounded-b">
        @include($footer)
        </footer>
    @endif
    @if (isset($form)) {!! Form::close() !!} @endif
</dialog>
