
<x-tutorial code="pagination">
    <p class="m-0">{!! __('crud.helpers.pagination.text', ['settings' => link_to_route('settings.appearance', __('crud.helpers.pagination.settings'), ['highlight' => 'pagination', 'from' => base64_encode(route($route . '.' . $action))])]) !!}</p>
</x-tutorial>
