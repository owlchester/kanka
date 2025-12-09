
<x-tutorial code="pagination">
    <p class="m-0">{!! __('crud.helpers.pagination.text', ['settings' => '<a href="' . route('settings.appearance', ['highlight' => 'pagination', 'from' => base64_encode(route($route . '.' . $action, $campaign))]) . '" class="text-link">' . __('crud.helpers.pagination.settings') . '</a>']) !!}</p>
</x-tutorial>
