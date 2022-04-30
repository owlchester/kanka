<?php
/**
 * @var \App\Models\CampaignDashboardWidget $widget
 * @var \App\Models\MiscModel $model
 */
$model = $widget->entity->child;
$entity = $widget->entity;

$specificPreview = 'dashboard.widgets.previews.' . $entity->type();
$customName = !empty($widget->conf('text')) ? str_replace('{name}', $model->name, $widget->conf('text')) : null;

\App\Facades\Dashboard::add($entity);
?>
@if(view()->exists($specificPreview))
    @include($specificPreview, ['entity' => $entity])
@else

<div class="panel panel-default widget-preview {{ $widget->customClass($campaign) }}" id="dashboard-widget-{{ $widget->id }}">
    <div
    @if ($widget->conf('entity-header') && $campaign->boosted() && $entity->header_image)
        class="panel-heading panel-heading-entity"
        style="background-image: url('{{ $entity->getImageUrl(1200, 400, 'header_image') }}')"
    @elseif ($widget->conf('entity-header') && $campaign->boosted(true) && $entity->header)
        class="panel-heading panel-heading-entity"
        style="background-image: url('{{ Img::crop(1200, 400)->url($entity->header->path) }}')"
    @elseif ($model->image)
        class="panel-heading panel-heading-entity"
        style="background-image: url('{{ $widget->entity->child->getImageUrl() }}')"
    @elseif($campaign->boosted(true) && !empty($entity->image))
        class="panel-heading panel-heading-entity"
        style="background-image: url('{{ Img::crop(1200, 400)->url($entity->image->path) }}')"
    @else
        class="panel-heading"
    @endif
    >
        <h3 class="panel-title">
            <a href="{{ $widget->entity->url() }}">
                @if ($model->is_private)
                    <i class="fas fa-lock pull-right" title="{{ trans('crud.is_private') }}"></i>
                @endif
                @if (!empty($widget->conf('text')))
                    {{ $customName }}
                @else
                    {{ $widget->entity->name }}
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

    @if ($widget->entity->typeId() == config('entities.ids.location'))
        @if (!empty($widget->entity->child->map))
            <div class="panel-footer text-right">
                <a href="{{ $widget->entity->url('map') }}">
                    <i class="fa-solid fa-map"></i> {{ __('locations.show.tabs.map') }}
                </a>
            </div>
        @endif
    @endif
</div>
@endif
