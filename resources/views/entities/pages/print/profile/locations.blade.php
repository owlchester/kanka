<?php /** @var \App\Models\Location $model */?>
@include('entities.pages.print.profile._type')
@include('entities.pages.print.profile._events')
@if (!$model->maps->isEmpty())
@php $counter = 0; @endphp
| {!! \App\Facades\Module::singular(config('entities.ids.map'), __('entities.map')) !!} | @foreach ($model->maps as $map) {!! $map->name !!} @if ($counter > $model->maps->count() - 1) @php $counter++ @endphp, @endif @endforeach |
@endif
