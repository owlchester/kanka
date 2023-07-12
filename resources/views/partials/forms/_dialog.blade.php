<x-dialog.header>
    @if (isset($titleIcon) && !empty($titleIcon))
        <span>{!! $titleIcon !!}</span>
    @endif
    {!! $title !!}
</x-dialog.header>
<article class="max-w-2xl">
    @include('partials.errors')
    @include($content)

    <x-dialog.footer>
        @if (isset($deleteID) && !empty($deleteID))
            <x-button.delete-confirm target="{{ $deleteID }}" />
        @endif
        @if (isset($actions))
            @includeWhen(!empty($actions), $actions)
        @else
            <button class="btn2 btn-primary">
                {{ $submit ?? __('crud.save') }}
            </button>
        @endif
    </x-dialog.footer>
</article>
