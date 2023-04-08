<header>
    <h4 id="ajax-dialog-label">
        {!! $slot !!}
    </h4>
    <button type="button" class="rounded-full" onclick="this.closest('dialog').close('close')">
        <i class="fa-solid fa-times" aria-hidden="true"></i>
        <span class="sr-only">{{ __('crud.delete_modal.close') }}</span>
    </button>
</header>
