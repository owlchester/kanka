<?php /** @var \App\Models\Family $model */?>
@if (!empty($model->family))
| {!! \App\Facades\Module::singular(config('entities.ids.family'), __('entities.family')) !!} | {!! $model->family->name !!} |
@endif
@include('entities.pages.print.profile._type')
@include('entities.pages.print.profile._events')
