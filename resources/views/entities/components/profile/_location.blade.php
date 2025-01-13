@if ($campaign->enabled('locations') && !empty($entity->child->location) && $entity->child->location->entity)
    <div class="element profile-location">
        <div class="title text-uppercase text-xs">{!! \App\Facades\Module::singular(config('entities.ids.location'), __('entities.location')) !!}</div>
        <x-entity-link
            :entity="$entity->child->location->entity"
            :campaign="$campaign" />
    </div>
@endif
