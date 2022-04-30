<?php
/**
 * @var \App\Models\Entity $entity
 * @var \App\Models\Character $model
 * @var \App\Models\Campaign $campaign
 * @var \App\Models\CampaignDashboardWidget $widget
 */
$model = $entity->child;
?>
<div class="panel panel-default widget-preview {{ $widget->customClass($campaign) }}" id="dashboard-widget-{{ $widget->id }}">
    <div
    @if ($widget->conf('entity-header') && $campaign->boosted() && $entity->header_image)
        class="panel-heading panel-heading-entity"
        style="background-image: url('{{ $entity->getImageUrl(1200, 400, 'header_image') }}')"
    @elseif ($widget->conf('entity-header') && $campaign->boosted(true) && $widget->entity->header)
        class="panel-heading panel-heading-entity"
        style="background-image: url('{{ Img::crop(1200, 400)->url($widget->entity->header->path) }}')"
    @elseif ($entity->child->image)
        class="panel-heading panel-heading-entity"
        style="background-image: url('{{ $entity->child->getImageUrl() }}')"
    @elseif($campaign->boosted(true) && !empty($entity->image))
        class="panel-heading panel-heading-entity"
        style="background-image: url('{{ Img::crop(1200, 400)->url($entity->image->path) }}')"
    @else
        class="panel-heading"
    @endif
    >
        <h3 class="panel-title">
            <a href="{{ $entity->child->getLink() }}">
                @if ($entity->child->is_private)
                    <i class="fas fa-lock pull-right" title="{{ trans('crud.is_private') }}"></i>
                @endif
                @if ($entity->child->is_dead)
                    <i class="ra ra-skull pull-right margin-r-5" title="{{ trans('characters.fields.is_dead') }}"></i>
                @endif

                @if(!empty($customName))
                    {{ $customName }}
                @elseif (!empty($widget->conf('text')))
                    {{ $widget->conf('text') }}
                @else
                    {{ $entity->name }}
                @endif

            </a>
        </h3>
    </div>
    <div class="panel-body">
        @if ($widget->conf('full') === '1')
            <div class="entity-content">
            {!! $model->entry() !!}
            </div>

            @include('dashboard.widgets.previews._members')
            @include('dashboard.widgets.previews._relations')
            @include('dashboard.widgets.previews._attributes')
        @else
            <div class="pinned-entity preview" data-toggle="preview" id="widget-preview-body-{{ $widget->id }}">
                <div class="entity-content">
                {!! $model->entry() !!}
                </div>

                @include('dashboard.widgets.previews._members')
                @include('dashboard.widgets.previews._relations')
                @include('dashboard.widgets.previews._attributes')
            </div>
            <a href="#" class="preview-switch hidden"
               id="widget-preview-switch-{{ $widget->id }}" data-widget="{{ $widget->id }}">
                <i class="fa-solid fa-chevron-down"></i>
            </a>
        @endif

    </div>
</div>
