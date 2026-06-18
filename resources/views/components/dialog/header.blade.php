<header class="flex gap-4 items-center p-4 md:p-6 justify-between">
    @if (isset($icon))
        {!! $icon !!}
    @endif
    <div class="grow flex flex-col gap-1">
        <h4 id="dialog-label-{{ $id }}" class="text-lg font-normal">
            {!! $slot !!}
        </h4>
        @if (isset($subtitle))
            <p class="text-neutral-content text-xs">{!! $subtitle !!}</p>
        @endif
    </div>
    @if ($dismissible)
    <x-dialog.close id="$id" />
    @endif
</header>
