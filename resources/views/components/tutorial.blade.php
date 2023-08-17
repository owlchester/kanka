
<div class="alert p-4 alert-info tutorial mb-5 rounded">
    <button type="button" class="text-xl opacity-50 hover:opacity-100 focus:opacity-100 cursor-pointer text-decoration-none banner-notification-dismiss float-right" data-dismiss="tutorial" aria-hidden="true" data-url="{{ route('settings.banner', ['code' => $code, 'type' => 'tutorial']) }}">
        <i class="fa-regular fa-circle-xmark" aria-hidden="true" data-toggle="tooltip" data-title="{{ __('crud.delete_modal.close') }}"></i>
    </button>
    {!! $slot !!}

    @if (!empty($doc))
        <p>
            {!!  __('crud.helpers.learn_more', ['documentation' => link_to($doc, '<i class="fa-solid fa-external-link" aria-hidden="true"></i> ' . __('footer.documentation'), ['target' => '_blank'], null, false)])!!}
        </p>
    @endif
</div>
