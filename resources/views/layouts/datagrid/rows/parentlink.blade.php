@if ($model->parent )
    <x-entity-link
        :entity="$model->parent->entity"
        :campaign="$campaign" />
@endif
