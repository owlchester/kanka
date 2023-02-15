<?php /**
 * @var \App\Models\Map $model
 */
?>
@if ($model->organisation)
    <div class="entity-header-sub pull-left">
        <i class="ra ra-hood" title="{{ __('entities.organisation') }}"></i>

        {!! $model->organisation->tooltipedLink() !!}
    </div>
@endif
