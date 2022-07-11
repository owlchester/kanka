<?php
/** @var \App\Models\MiscModel $model */
$forceShow = false;
if (method_exists($model, 'pinnedMembers') && !$model->pinnedMembers->isEmpty()) {
    $forceShow = true;
}
if (auth()->check() && auth()->user()->can('update', $model)) {
    $forceShow = true;
}
?>

@if ($forceShow || $model->entity->hasPins())
    <div class="sidebar-section-box entity-pins {{ $model->entity->hasPins() ? '' : 'entity-empty-pin' }}">
        <div class="sidebar-section-title cursor" data-toggle="collapse" data-target="#sidebar-pinned-elements">
            <i class="fa-solid fa-chevron-right" style="display: none"></i>
            <i class="fa-solid fa-chevron-down"></i>

            {{ __('entities/pins.title') }}
            <i class="fa-solid fa-question-circle pull-right" data-toggle="ajax-modal" role="button" data-target="#entity-modal" data-url="{{ route('helpers.pins') }}"></i>
        </div>
        <div class="sidebar-elements collapse in" id="sidebar-pinned-elements">

            <ul class="pins m-0 p-0">
                @include('entities.components.relations')
                @includeWhen(method_exists($model, 'pinnedMembers') && !$model->pinnedMembers->isEmpty(), 'entities.components.members')
                @includeWhen($model->entity->accessAttributes(), 'entities.components.attributes')
            </ul>
        </div>
    </div>
@endif

@includeIf('entities.components.profile.' . $name)

@includeWhen(!isset($printing) && $campaignService->campaign()->boosted() && $model->entity->hasLinks(), 'entities.components.links')
