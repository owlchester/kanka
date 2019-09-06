<?php
/** @var \App\Models\MiscModel $model */
$model = $widget->entity->child;

$specificPreview = 'dashboard.widgets.previews.' . $widget->entity->type;
?>
@if(view()->exists($specificPreview))
    @include($specificPreview)
@else
<div class="panel panel-default widget-preview" id="dashboard-widget-{{ $widget->id }}">
    <div class="panel-heading @if ($model->image) panel-heading-entity" style="background-image: url({{ $widget->entity->avatar() }}) @endif">
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
        <div class="pinned-entity preview" data-toggle="preview" id="widget-preview-body-{{ $widget->id }}">
            {!! $model->entry() !!}
        </div>
        <a href="#" class="preview-switch hidden"
           id="widget-preview-switch-{{ $widget->id }}" data-widget="{{ $widget->id }}">
            <i class="fa fa-chevron-down"></i>
        </a>
    </div>

    @if ($widget->entity->type == \App\Models\Entity::TYPE_LOCATION)
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