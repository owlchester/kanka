<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Character $model
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignDashboardWidget $widget
 */
$model = $entity->child;
?>
<div class="panel panel-default widget-preview" id="dashboard-widget-{{ $widget->id }}">
    <div class="panel-heading @if ($widget->conf('entity-header') && $campaign->boosted() && $entity->header_image) panel-heading-entity" style="background-image: url({{ $entity->getImageUrl(0, 0, 'header_image') }}) @elseif($entity->child->image) panel-heading-entity" style="background-image: url({{ $entity->child->getImageUrl() }}) @endif">
        <h3 class="panel-title">
            <a href="{{ $entity->child->getLink() }}">
                @if ($entity->child->is_private)
                    <i class="fas fa-lock pull-right" title="{{ trans('crud.is_private') }}"></i>
                @endif
                @if ($entity->child->is_dead)
                    <i class="ra ra-skull pull-right margin-r-5" title="{{ trans('characters.fields.is_dead') }}"></i>
                @endif

                {{ $entity->name }}

            </a>
        </h3>
    </div>
    <div class="panel-body">
        @if ($widget->conf('full') === '1')
            {!! $model->entry() !!}
        @else
            <div class="pinned-entity preview" data-toggle="preview" id="widget-preview-body-{{ $widget->id }}">
                {!! $model->entry() !!}
            </div>
            <a href="#" class="preview-switch hidden"
               id="widget-preview-switch-{{ $widget->id }}" data-widget="{{ $widget->id }}">
                <i class="fa fa-chevron-down"></i>
            </a>
        @endif
    </div>
</div>
