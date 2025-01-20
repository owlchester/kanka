<header class="bg-base-200 sm:rounded-t">
    <h4 id="dialog-label-{{ $id }}">
        {!! $slot !!}
    </h4>
    @if ($dismissible)
    <x-dialog.close id="$id" />
    @endif
</header>
