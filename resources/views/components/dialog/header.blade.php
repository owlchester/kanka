<header class="bg-base-200 sm:rounded-t">
    <h4>
        {!! $slot !!}
    </h4>
    @if ($dismissible)
    <x-dialog.close />
    @endif
</header>
