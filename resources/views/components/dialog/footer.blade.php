<div {{ $attributes->merge(['class' => 'mt-5 flex gap-2 md:gap-5 text-left w-full justify-between p-4 md:p-6']) }}>
    @if (isset($cancel))
        {!! $cancel !!}
    @else
    <menu class="flex flex-wrap gap-3 ps-0 ms-0">
        <button type="button" class="btn2 btn-outline" onclick="this.closest('dialog').close('close')">
            {{ __('crud.cancel') }}
        </button>
    </menu>
    @endif
    {!! $slot !!}
</div>
