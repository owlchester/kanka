<?php /** @var \App\Models\Location $model */?>
@include('entities.pages.print.profile._type')
@include('entities.pages.print.profile._events')
@if (!$model->maps->isEmpty())
| {!! \App\Facades\Module::singular(config('entities.ids.map'), __('entities.map')) !!} | |
@foreach ($model->maps as $map)
| | {!! $map->tooltipedLink() !!} {!! $map->exploreLink() !!} |
@endforeach
@endif
