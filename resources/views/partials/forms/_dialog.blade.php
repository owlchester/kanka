<x-dialog.header>
    @if (isset($titleIcon) && !empty($titleIcon))
        <span>{!! $titleIcon !!}</span>
    @endif
    {!! $title !!}
</x-dialog.header>
<div class="container">
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


</div>
