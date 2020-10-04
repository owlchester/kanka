<?php
/**
 * @var \App\Models\CampaignDashboardWidget $widget
 * @var \App\Models\MiscModel $model
 */
$model = $widget->entity->child;

$specificPreview = 'dashboard.widgets.previews.' . $widget->entity->type;

\App\Facades\Dashboard::add($widget->entity);
?>
@if(view()->exists($specificPreview))
    @include($specificPreview, ['entity' => $widget->entity])
@else
<div class="panel panel-default widget-preview" id="dashboard-widget-{{ $widget->id }}">
    <div class="panel-heading @if ($widget->conf('entity-header') && $campaign->boosted() && $widget->entity->header_image) panel-heading-entity" style="background-image: url({{ $widget->entity->getImageUrl(1200, 400, 'header_image') }}) @elseif ($model->image) panel-heading-entity" style="background-image: url({{ $widget->entity->child->getImageUrl() }}) @endif">
        <h3 class="panel-title">
            <a href="{{ $widget->entity->url() }}">
                @if ($model->is_private)
                    <i class="fas fa-lock pull-right" title="{{ trans('crud.is_private') }}"></i>
                @endif
                {{ $widget->entity->name }}
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

    @if ($widget->entity->typeId() == config('entities.ids.location'))
        @if (!empty($widget->entity->child->map))
            <div class="panel-footer text-right">
                <a href="{{ $widget->entity->url('map') }}">
                    <i class="fa fa-map"></i> {{ __('locations.show.tabs.map') }}
                </a>
            </div>
        @endif
    @endif
</div>
@endif
