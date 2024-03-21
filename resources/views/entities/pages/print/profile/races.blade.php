<?php /** @var \App\Models\Map $model */?>
@if ($campaign->enabled('locations') && !$model->locations->isEmpty())
| {!! \App\Facades\Module::plural(config('entities.ids.location'), __('entities.locations')) !!} | |
@php $existingRaces = []; @endphp
@foreach ($model->locations as $location)
@if(!empty($existingLocations[$location->id]))
@continue
@endif
@php $existingLocations[$location->id] = true; @endphp
| | {!! $location->tooltipedLink() !!} |
@endforeach
@endif
@include('entities.pages.print.profile._type')