<?php
/** @var \App\Models\MiscModel $model */
$attributes = count($model->entity->starredAttributes);
$mainClass = $attributes > 0 ? 'col-lg-7 col-md-6' : 'col-md-9';
$sideClass = $attributes > 0 ? 'col-lg-2 col-md-3' : 'hidden';
?>
<div class="row">
    <div class="col-md-3">
        @include('dice_rolls._menu')
    </div>

    <div class="{{ $mainClass }}">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#results" data-toggle="tooltip" title="{{ trans('dice_rolls.show.tabs.results') }}">
                        <i class="fa fa-th-list"></i> <span class="hidden-sm hidden-xs"> {{ trans('dice_rolls.show.tabs.results') }}
                    </a>
                </li>
                @include('cruds._tabs')
            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="results">
                    @include('dice_rolls._results')
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
