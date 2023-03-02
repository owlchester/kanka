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
        <div class="sidebar-section-title cursor-pointer text-lg user-select" data-toggle="collapse" data-target="#sidebar-pinned-elements">
            <i class="fa-solid fa-chevron-right" style="display: none"></i>
            <i class="fa-solid fa-chevron-down"></i>

            {{ __('entities/pins.title') }}
            <a href="//docs.kanka.io/en/latest/features/profile-sidebar.html" target="_blank">
                <i class="fa-solid fa-question-circle pull-right" ></i>
            </a>
        </div>
        <div class="sidebar-elements collapse in" id="sidebar-pinned-elements">

            <ul class="pins m-0 p-0">
                @includeWhen(!$model->entity->pinnedFiles->isEmpty(), 'entities.components.assets')
                @include('entities.components.relations')
                @includeWhen(method_exists($model, 'pinnedMembers') && !$model->pinnedMembers->isEmpty(), 'entities.components.members')
                @includeWhen($model->entity->accessAttributes(), 'entities.components.attributes')
            </ul>
        </div>
    </div>
@endif

@includeIf('entities.components.profile.' . $name)

@includeWhen(!isset($printing) && $campaignService->campaign()->boosted() && $model->entity->hasLinks(), 'entities.components.links')
