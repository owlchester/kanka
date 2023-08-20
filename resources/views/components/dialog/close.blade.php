@if ($modal || $dismiss == 'alert')<button autofocus type="button" class="float-right text-xl opacity-50 hover:opacity-100 focus:opacity-100 cursor-pointer text-decoration-none" data-dismiss="{{ $dismiss ?? 'modal' }}" aria-label="{{ __('crud.delete_modal.close') }}">
    <x-icon class="fa-regular fa-circle-xmark"></x-icon>
    <span class="sr-only">{{ __('crud.delete_modal.close') }}</span>
</button>@else
<button autofocus type="button" class="float-right text-xl rounded-full bg-base-300 opacity-80 hover:opacity-100" onclick="this.closest('dialog').close('close')" title="{{ __('crud.delete_modal.close') }}">
    <x-icon class="fa-regular fa-times"></x-icon>
    <span class="sr-only">{{ __('crud.delete_modal.close') }}</span>
</button>
@endif
