
<div class="m-5 alert alert-info tutorial">
    <button type="button" class="close banner-notification-dismiss" data-dismiss="alert" aria-hidden="true" data-url="{{ route('settings.banner', ['code' => 'pagination', 'type' => 'tutorial']) }}">×</button>

    <p>{!! __('crud.helpers.pagination.text', ['settings' => link_to_route('settings.appearance', __('crud.helpers.pagination.settings'), ['highlight' => 'pagination', 'from' => base64_encode(route($route . '.' . $action))])]) !!}</p>
</div>
