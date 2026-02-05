<?php /** @var \App\Models\Entity $entity */ ?>
@if (empty($with) && $model->entity->locations->isNotEmpty())
    @foreach ($model->entity->locations as $location)
        <x-entity-link
            :entity="$location->entity"
            :campaign="$campaign" />
    @endforeach
@elseif ($model->{$with} && $model->{$with}->locations->isNotEmpty())
    @foreach ($model->{$with}->locations as $location)
        <x-entity-link
            :entity="$location->entity"
            :campaign="$campaign" />
    @endforeach
@endif
