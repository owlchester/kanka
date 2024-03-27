@if (!empty($model->type))
@php
$defaultOptions = auth()->check() && auth()->user()->entityExplore === '1' ? [$campaign, 'm' => 'table'] : [$campaign];
@endphp
| {{ __('crud.fields.type') }} | {{ $model->type }} |
@endif
