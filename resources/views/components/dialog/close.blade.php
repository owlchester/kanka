<button type="button" class="text-xl opacity-50 hover:opacity-100 focus:opacity-100 cursor-pointer text-decoration-none" data-dismiss="{{ $dismiss ?? 'modal' }}" aria-label="{{ __('crud.actions.close') }}" @if (!empty($id)) id="{{ $id }}-close" @endif onclick="this.closest('dialog').close('close')">
    <x-icon class="fa-regular fa-circle-xmark" />
    <span class="sr-only">{{ __('crud.actions.close') }}</span>
</button>
