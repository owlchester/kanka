<div class="field field-{{ $field }} flex flex-col gap-1
    @if (isset($required) && $required) required @endif {{ $css ?? null }}
    @if ($hidden) hidden @endif"
>
    @if (isset($label) && !empty($label))
        <label class="" @if (isset($id)) for="{{ $id }}" @endif>
            {!! $label !!}
            @if ($tooltip && isset($helper))
                @if (isset($link))
                    <a href="{{ $link }}" target="_blank">
                        <x-helpers.tooltip :title="$helper" />
                    </a>
                @else
                    <x-helpers.tooltip :title="$helper" />
                @endif
            @endif
        </label>
    @else
    @endif
    {!! $slot !!}
    @if (isset($helper) && !empty($helper))
        <p class="m-0 text-neutral-content text-xs @if ($tooltip) md:hidden @endif">
            <x-icon class="fa-regular fa-circle-info" />
            {!! $helper !!}
            @if (isset($link))
                <a href="{{ $link }}" target="_blank">
                    {{ __('crud.helpers.learn_more', ['documentation' => __('footer.documentation')]) }}
                </a>
            @endif
        </p>
    @endif
</div>
