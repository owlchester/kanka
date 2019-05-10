<?php
/** @var \App\Models\Character $model */
$model = $widget->entity->child;
?>
<div class="panel panel-default widget-preview" id="dashboard-widget-{{ $widget->id }}">
    <div class="panel-heading @if ($model->image) panel-heading-entity" style="background-image: url({{ $model->getImageUrl() }}) @endif">
        <h3 class="panel-title">
            <a href="{{ $model->getLink() }}">

                @if ($model->is_private)
                    <i class="fas fa-lock pull-right" title="{{ trans('crud.is_private') }}"></i>
                @endif
                @if ($model->is_dead)
                    <i class="ra ra-skull pull-right margin-r-5" title="{{ trans('characters.fields.is_dead') }}"></i>
                @endif

                {{ $widget->entity->name }}

            </a>
            @if ($campaign->enabled('families') && !empty($model->family))
                {{--<a href="{{ route('families.show', $model->family->id) }}" data-toggle="tooltip" title="{{ $model->family->tooltipWithName() }}" data-html="true">--}}
                    {{--{{ $model->family->name }}--}}
                {{--</a>--}}
            @endif

        </h3>
    </div>
    <div class="panel-body">
        <div class="pinned-entity preview" data-toggle="preview" id="widget-preview-body-{{ $widget->id }}">
            {!! $model->entry !!}
        </div>
        <a href="#" class="preview-switch hidden"
           id="widget-preview-switch-{{ $widget->id }}" data-widget="{{ $widget->id }}">
            <i class="fa fa-chevron-down"></i>
        </a>
    </div>
</div>