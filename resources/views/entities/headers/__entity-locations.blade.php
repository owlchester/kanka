<?php
/** @var \App\Models\Entity $entity */
use Illuminate\Support\Facades\Blade;
if (!$campaign->enabled('locations') || $entity->locations->isEmpty()) {
    return;
}
?>
<div class="entity-header-sub-element flex gap-2 items-center">
    <x-icon :class="$entity->locations[0]->entity->entityType->icon()" :title="$entity->locations[0]->entity->entityType->name()" />
    <ul class="list-none p-0">
    @foreach ($entity->locations as $location)
        <li class="inline after:content-[','] after:mr-1 last:after:content-none">
        <x-entity-link
            :entity="$location->entity"
            :campaign="$campaign" />
        </li>
    @endforeach
    </ul>

</div>
