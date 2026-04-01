<?php
if (!$campaign->enabled('locations') || !$entity->parent) {
    return;
}
?>
<div class="entity-header-sub-element">
    <x-icon :class="$entityType->icon()" :title="__('crud.fields.parent')" />
    @if ($entity->parent->parent)
        {!! __('crud.fields.locations', [
            'first' => \Illuminate\Support\Facades\Blade::renderComponent(
                new \App\View\Components\EntityLink($entity->parent, $campaign)
                ),
            'second' => \Illuminate\Support\Facades\Blade::renderComponent(
                new \App\View\Components\EntityLink($entity->parent->parent, $campaign)
                ),
        ]) !!}
    @else
        <x-entity-link
            :entity="$entity->parent"
            :campaign="$campaign" />
    @endif
</div>
