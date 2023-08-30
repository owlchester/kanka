<header class="bg-base-200 sm:rounded-t">
    <h4 id="ajax-dialog-label">
        {!! $slot !!}
    </h4>
    @if ($dismissible)
    <x-dialog.close />
    @endif
</header>
