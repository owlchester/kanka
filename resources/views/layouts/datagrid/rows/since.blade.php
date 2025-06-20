@if (!empty($model->{$key}))
    <x-since :date="$model->{$key}" />
@endif
