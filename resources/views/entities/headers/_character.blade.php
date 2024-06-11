<?php /**
 * @var \App\Models\Character $model
 */
?>


@if (!$campaign->enabled('locations') || empty($model->location))
    <?php return ?>
@endif

<div class="entity-header-sub entity-header-line">
    @include('entities.headers.__location')
</div>


