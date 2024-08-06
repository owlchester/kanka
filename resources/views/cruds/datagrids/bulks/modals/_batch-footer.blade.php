<menu class="flex flex-wrap gap-3 ps-0 ms-0">
    <button autofocus type="button" class="btn2 btn-ghost btn-full" onclick="this.closest('dialog').close('close')">
        {{ __('crud.cancel') }}
    </button>
</menu>
<menu class="flex flex-wrap gap-3 ps-0">
    <button class="btn2 btn-primary" type="submit">
        <x-icon class="save" />
        {{ __('crud.actions.apply') }}
    </button>
</menu>
