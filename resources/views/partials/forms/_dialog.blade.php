<x-dialog.header>
    @if (isset($titleIcon) && !empty($titleIcon))
        <span>{!! $titleIcon !!}</span>
    @endif
    {!! $title !!}
</x-dialog.header>
<article class="max-w-2xl {{ $articleClass ?? null }}">
    @include('partials.errors')
    @include($content)
</article>
<footer class="bg-base-200 flex flex-wrap gap-3 justify-between items-start p-3 md:rounded-b">
    aaaa
    @if (isset($footer))bbb
        @include($footer)
    @else cccc
        @include('partials.forms.dialog.footer')
    @endif
</footer>

