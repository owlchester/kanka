<header class="flex gap-6 items-center p-4 md:p-6 justify-between">
    <h4 id="dialog-label-{{ $id }}" class="text-lg font-normal">
        {!! $slot !!}
    </h4>
    @if ($dismissible)
    <x-dialog.close id="$id" />
    @endif
</header>
