<x-dialog.header>
    @if (isset($icon) && !empty($icon))
        <x-slot name="icon">{!! $icon !!}</x-slot>
    @endif
    {!! $title !!}
    @if (isset($subtitle) && !empty($subtitle))
        <x-slot name="subtitle">{!! $subtitle !!}</x-slot>
    @endif
</x-dialog.header>
<article class="max-w-2xl py-4 px-4 md:px-6 {{ $articleClass ?? null }}">
    @include('partials.errors')
    @include($content)
</article>

<footer class="flex flex-wrap gap-2 justify-between items-start p-4 md:p-6">
    @if (isset($footer))
        @include($footer)
    @else
        @include('partials.forms.dialog.footer')
    @endif
</footer>
