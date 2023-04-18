
<div class="alert alert-info tutorial">
    <span>
        <button type="button" class="close banner-notification-dismiss" data-dismiss="tutorial" aria-hidden="true" data-url="{{ route('settings.banner', ['code' => $code, 'type' => 'tutorial']) }}">×</button>
    </span>
    {!! $slot !!}

    @if (!empty($doc))
        <p>
            {!!  __('crud.helpers.learn_more', ['documentation' => link_to($doc, '<i class="fa-solid fa-external-link" aria-hidden="true"></i> ' . __('front.menu.documentation'), ['target' => '_blank'], null, false)])!!}
        </p>
    @endif
</div>
