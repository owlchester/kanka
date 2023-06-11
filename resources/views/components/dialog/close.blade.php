@if ($modal)<button type="button" class="float-right text-xl opacity-50 hover:opacity-100 focus:opacity-100 cursor-pointer text-decoration-none" data-dismiss="{{ $dismiss ?? 'modal' }}" aria-label="{{ __('crud.delete_modal.close') }}">
    <i class="fa-regular fa-circle-xmark" aria-hidden="true" data-toggle="tooltip" title="{{ __('crud.delete_modal.close') }}"></i>
</button>@else
<button type="button" class="float-right text-xl rounded-full bg-base-300 opacity-80 hover:opacity-100" onclick="this.closest('dialog').close('close')" title="{{ __('crud.delete_modal.close') }}">
    <i class="fa-solid fa-times" aria-hidden="true"></i>
    <span class="sr-only">{{ __('crud.delete_modal.close') }}</span>
</button>
@endif
