<{{ $element }}
    class="rounded {{ $sizes }} border uppercase cursor-pointer font-extrabold hover:shadow-xs transition-all duration-150
    @if ($full) w-full @endif {{ $colours }}"
    @if ($target) data-toggle="dialog" data-target="{{ $target }}"@endif
    @if ($name) name="{{ $name }}"@endif
    @if ($dismiss === 'dialog') onclick="this.closest('dialog').close('close')"@endif
>
    <div class="flex gap-2 items-center justify-center">
    {!! $slot !!}
    </div>
</{{ $element }}>
