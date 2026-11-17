<header @class(['flex gap-4 items-center p-4 md:p-6 justify-between', 'mobile-panel-header' => $mobileBack])>
    @if ($dismissible && $mobileBack)
        <button type="button" class="mobile-panel-back flex min-h-11 shrink-0 items-center gap-2 text-sm text-neutral-content md:hidden"
            @if ($mobileBackUrl)
                data-toggle="entity-creator" data-url="{{ $mobileBackUrl }}"
            @else
                data-dialog-back
            @endif>
            <x-icon class="fa-regular fa-angle-left" />
            {{ __('crud.actions.back') }}
        </button>
    @endif
    @if (isset($icon))
        {!! $icon !!}
    @endif
    <div class="dialog-heading grow flex flex-col gap-1">
        <h4 id="dialog-label-{{ $id }}" class="text-lg font-normal">
            @if ($mobileTitle)
                <span class="mobile-panel-title md:hidden">{{ $mobileTitle }}</span>
                <span class="hidden md:inline">{!! $slot !!}</span>
            @else
                {!! $slot !!}
            @endif
        </h4>
        @if (isset($subtitle))
            <p class="text-neutral-content text-xs">{!! $subtitle !!}</p>
        @endif
    </div>
    @if ($dismissible)
        <div @class(['hidden md:block' => $mobileBack])>
            <x-dialog.close id="$id" />
        </div>
    @endif
</header>
