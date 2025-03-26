<dialog class="dialog rounded-t-2xl md:rounded-2xl bg-base-100 min-w-fit shadow text-base-content md:mx-8" id="{{ $id }}" aria-modal="true" aria-hidden="true" aria-labelledby="dialog-label-{{ $id }}" @if (!$dismissible) data-dismissible="false" @endif>
    <x-dialog.header :id="$id">
        @if ($loading)
            {{ __('Loading') }}
        @else
            {!! $title !!}
        @endif
    </x-dialog.header>
    @if (!empty($form)) {!! $form !!} @else <div class="formless"> @endif
        <article class="py-4 px-4 md:px-6 @if (!$full) max-w-2xl @endif">
            @if ($loading)
                <div class="my-8 text-center text-lg w-40">
                    <x-icon class="load" />
                </div>
            @endif
            {{ $slot }}
        </article>
        @if (isset($footer))
            <x-dialog.footer>
                @includeIf($footer)
            </x-dialog.footer>
            <footer class="flex flex-wrap gap-2 justify-between items-start p-4 md:p-6">
            </footer>
        @endif
    @if (!empty($form)) </form> @else </div> @endif
</dialog>
