@if (!empty($model->type))
@php
$defaultOptions = [$campaign];
@endphp
| {{ __('crud.fields.type') }} | {{ $model->type }} |
@endif
