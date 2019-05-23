<?php
/** @var \App\Models\MiscModel $model */
$attributes = count($model->entity->starredAttributes);
$mainClass = $attributes > 0 ? 'col-lg-7 col-md-6' : 'col-md-9';
$sideClass = $attributes > 0 ? 'col-lg-2 col-md-3' : 'hidden';
?>
<div class="row">
    <div class="col-md-3">
        @include('events._menu')
    </div>

    <div class="{{ $mainClass }}">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="{{ (request()->get('tab') == null ? ' active' : '') }}">
                    <a href="#entry" data-toggle="tooltip" title="{{ trans('events.show.tabs.information') }}">
                        <i class="fa fa-align-justify"></i> <span class="hidden-sm hidden-xs">{{ trans('events.show.tabs.information') }}</span>
                    </a>
                </li>
                @include('cruds._tabs')
            </ul>

            <div class="tab-content">
                <div class="tab-pane {{ (request()->get('tab') == null ? ' active' : '') }}" id="entry">
                    @if (!empty($model->entry))
                        <p>{!! $model->entry !!}</p>
                    @endif
                    @include('cruds.partials.mentions')
                </div>

                @include('cruds._panes')
            </div>
        </div>
        @include('cruds.boxes.history')
    </div>

    <div class="{{ $sideClass }}">
        @include('entities.components.attributes')
    </div>
</div>
