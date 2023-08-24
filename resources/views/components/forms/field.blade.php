<div class="field field-{{ $field }} flex flex-col gap-1 @if (isset($required) && $required) required @endif">
    @if (isset($label))
        <label class="m-0">
            {!! $label !!}
            @if ($tooltip && isset($helper))
                <x-helpers.tooltip :title="$helper" />
            @endif
        </label>
    @endif
    {!! $slot !!}
    @if (isset($helper))
        <p class="m-0 text-neutral-content @if ($tooltip) md:hidden @endif">{!! $helper !!}</p>
    @endif
</div>
