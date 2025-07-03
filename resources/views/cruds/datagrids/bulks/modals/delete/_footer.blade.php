
<menu class="flex flex-wrap gap-3 ps-0 ms-0">
    <button autofocus type="button" class="btn2 btn-outline btn-full" onclick="this.closest('dialog').close('close')">
        {{ __('crud.cancel') }}
    </button>
</menu>
<menu class="flex flex-wrap gap-3 ps-0">
    <button type="submit" class="btn2 btn-error btn-outline" name="datagrid-action" value="delete">
        <x-icon class="trash" />
        <span class="remove-button-label">{{ __('crud.remove') }}</span>
    </button>
</menu>
