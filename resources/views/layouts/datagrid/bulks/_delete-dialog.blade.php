<x-dialog id="datagrid-bulk-delete" :title="__('crud.delete_modal.title')">
    <x-grid type="1/1">
        <p class="text-neutral-content">
            {{ __('confirm.delete.bulk') }}</p>
        <p class="text-neutral-content">
            {{ __('crud.delete_modal.permanent') }}
        </p>
    </x-grid>

    <x-dialog.footer :dialog="true">
        <button type="button" class="btn2 btn-error btn-outline" id="datagrid-action-confirm">
            <x-icon class="trash" />
            <span class="remove-button-label">{{ __('crud.remove') }}</span>
        </button>
    </x-dialog.footer>
</x-dialog>
