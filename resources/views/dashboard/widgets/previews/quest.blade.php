<?php
/** @var \App\Models\MiscModel $model */
$model = $widget->entity->child;
?>
<div class="panel panel-default widget-preview" id="dashboard-widget-{{ $widget->id }}">
    <div class="panel-heading @if ($model->image) panel-heading-entity" style="background-image: url({{ $model->getImageUrl() }}) @endif">
        <h3 class="panel-title">
            <a href="{{ $model->getLink() }}">
                {{ $widget->entity->name }}
            </a>

            @if ($model->is_private)
                <i class="fas fa-lock pull-right" title="{{ trans('crud.is_private') }}"></i>
            @endif
        </h3>
    </div>
    <div class="panel-body">
        <div class="pinned-entity preview" data-toggle="preview" id="widget-preview-body-{{ $widget->id }}">

            <dl class="dl-horizontal">
                @if ($campaign->enabled('characters') && !empty($model->character))
                    <dt>{{ __('quests.fields.character') }}</dt>
                    <dd>
                        <a href="{{ route('characters.show', $model->character->id) }}" data-toggle="tooltip" title="{{ $model->character->tooltip() }}">
                            {{ $model->character->name }}
                        </a>
                    </dd>
                @endif

                @if ($model->is_completed)
                    <dt>{{ __('quests.fields.is_completed') }}</dt>
                    <dd>{{ __('voyager.generic.yes') }}</dd>
                @endif
            </dl>

            {!! $model->entry !!}
        </div>
        <a href="#" class="preview-switch hidden"
           id="widget-preview-switch-{{ $widget->id }}" data-widget="{{ $widget->id }}">
            <i class="fa fa-chevron-down"></i>
        </a>
    </div>
</div>