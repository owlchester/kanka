@if (!empty($model->type))
@php
$defaultOptions = auth()->check() && auth()->user()->entityExplore === '1' ? [$campaign, 'm' => 'table'] : [$campaign];
@endphp
| {{ __('crud.fields.type') }} | {!! link_to_route($entity->pluralType() . '.index', $model->type, $defaultOptions + ['_clean' => true, 'type' => $model->type]); !!} |
@endif
