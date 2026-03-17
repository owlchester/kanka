@if ($model->parent )
    <x-entity-link
        :entity="$model->parent"
        :campaign="$campaign" />
@endif
