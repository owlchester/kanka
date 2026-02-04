<?php /** @var \App\Models\Creature $model */?>
@if ($campaign->enabled('locations') && !$model->entity->locations->isEmpty())
@php
$existingLocations = [];
$counter = 0;
@endphp
| {!! \App\Facades\Module::plural(config('entities.ids.location'), __('entities.locations')) !!} | @foreach ($model->entity->locations as $location) @if(!empty($existingLocations[$location->id])) @continue @endif @php $existingLocations[$location->id] = true; @endphp {!! $location->name !!}@if ($counter < $model->entity->locations->count())@php $counter++; @endphp, @endif @endforeach |
@endif
@include('entities.pages.print.profile._type')
