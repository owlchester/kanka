<x-dialog.header>
    @if (isset($titleIcon) && !empty($titleIcon))
        <span>{!! $titleIcon !!}</span>
    @endif
    {!! $title !!}
</x-dialog.header>
<article class="max-w-2xl">
    @include('partials.errors')
    @include($content)

</article>
<footer class="bg-base-200 flex flex-wrap gap-3 justify-between items-start p-3">
    <menu class="flex flex-wrap gap-3 ps-0 ms-0">
        <button autofocus type="button" class="btn2 btn-ghost btn-full" onclick="this.closest('dialog').close('close')">
            {{ __('crud.cancel') }}
        </button>
    </menu>
    <menu class="flex flex-wrap gap-3 ps-0">
        @if (isset($deleteID) && !empty($deleteID))
            <x-button.delete-confirm target="{{ $deleteID }}" />
        @endif
        @if (isset($actions))
            @includeWhen(!empty($actions), $actions)
        @else
            <div class="submit-group">
                <button class="btn2 btn-primary">
                    {{ $submit ?? __('crud.save') }}
                </button>
            </div>
        @endif
    </menu>
</footer>
