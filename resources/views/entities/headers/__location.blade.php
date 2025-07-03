<?php
use Illuminate\Support\Facades\Blade;
if (!$campaign->enabled('locations') || !$entity->child->location || !$entity->child->location->entity) {
    return;
}
?>
<div class="entity-header-sub-element">
    <x-icon :class="\App\Facades\Module::duoIcon('location')" :title="__('crud.fields.parent')" />
    @if ($entity->child->location->parent && $entity->child->location->parent->entity)
        {!! __('crud.fields.locations', [
            'first' => Blade::renderComponent(
                new \App\View\Components\EntityLink($entity->child->location->entity, $campaign)
                ),
            'second' => Blade::renderComponent(
                new \App\View\Components\EntityLink($entity->child->location->parent->entity, $campaign)
                ),
        ]) !!}
    @else
        <x-entity-link
            :entity="$entity->child->location->entity"
            :campaign="$campaign" />
    @endif
</div>
