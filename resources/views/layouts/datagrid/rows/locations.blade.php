<?php /** @var \App\Models\Entity $entity */ ?>
@php
$target = empty($with) ? $model->entity : data_get($model, $with);
@endphp
@if ($target?->locations->isNotEmpty())
    @foreach ($target->locations as $location)
        <x-entity-link
            :entity="$location->entity"
            :campaign="$campaign" />
    @endforeach
@endif
