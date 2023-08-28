<div class="field field-{{ $field }} flex flex-col gap-1 @if (isset($required) && $required) required @endif">
    @if (isset($label) && !empty($label))
        <label class="">
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
    @endif
    {!! $slot !!}
    @if (isset($helper) && !empty($helper))
        <p class="m-0 text-neutral-content @if ($tooltip) md:hidden @endif">
            {!! $helper !!}
            @if (isset($link))
                <a href="{{ $link }}" target="_blank">
                    {{ __('crud.helpers.learn_more', ['documentation' => __('footer.documentation')]) }}
                </a>
            @endif
        </p>
    @endif
</div>
