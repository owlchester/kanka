<?php
?>


@if (!$campaign->enabled('locations') || empty($entity->child->location))
    <?php return ?>
@endif

<div class="entity-header-sub entity-header-line">
    @include('entities.headers.__location')
</div>


