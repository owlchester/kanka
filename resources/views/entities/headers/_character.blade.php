<?php
?>


@if (!$campaign->enabled('locations') || $entity->locations->isEmpty())
    <?php return ?>
@endif

<div class="entity-header-sub entity-header-line">
    @include('entities.headers.__entity-locations')
</div>


