<?php
if (!$campaign->enabled('locations') || !$entity->child->parent || !$entity->child->parent->entity) {
    return;
}
?>
<div class="entity-header-sub-element">
    <x-icon :class="\App\Facades\Module::duoIcon('location')" :title="__('crud.fields.parent')" />
    @if ($entity->child->parent->parent && $entity->child->parent->parent->entity)
        {!! __('crud.fields.locations', [
            'first' => \Illuminate\Support\Facades\Blade::renderComponent(
                new \App\View\Components\EntityLink($entity->child->parent->entity, $campaign)
                ),
            'second' => \Illuminate\Support\Facades\Blade::renderComponent(
                new \App\View\Components\EntityLink($entity->child->parent->parent->entity, $campaign)
                ),
        ]) !!}
    @else
        <x-entity-link
            :entity="$entity->child->parent->entity"
            :campaign="$campaign" />
    @endif
</div>
