<button type="button" class="text-2xl opacity-60 hover:opacity-100 hover:bg-base-200 focus:bg-base-200 cursor-pointer w-8 h-8 flex items-center justify-center rounded-lg" data-dismiss="{{ $dismiss ?? 'modal' }}" title="{{ __('crud.actions.close') }}" @if (!empty($id)) id="{{ $id }}-close" @endif onclick="this.closest('dialog').close('close')" aria-label="Close dialog" >
    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"></path>
    </svg>
</button>
