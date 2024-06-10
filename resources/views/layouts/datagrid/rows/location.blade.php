@if (empty($with))
    <x-entity-link
        :entity="$model->location->entity"
        :campaign="$campaign" />
@elseif ($model->{$with} && $model->{$with}->location)
    <x-entity-link
        :entity="$model->{$with}->location->entity"
        :campaign="$campaign" />
@endif
