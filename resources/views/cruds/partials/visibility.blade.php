<?php
use App\Models\Scopes\VisibilityScope;
/** @var \App\Models\EntityNote $model */
$live = isset($live) && $live;
if (!$live && $model->visibility == VisibilityScope::VISIBILITY_ALL) {
    return;
}

$icon = "fas fa-" . (in_array($model->visibility, [VisibilityScope::VISIBILITY_SELF, VisibilityScope::VISIBILITY_ADMIN_SELF]) ? 'user-' : '') . 'lock';
if ($model->visibility == \App\Models\Scopes\VisibilityScope::VISIBILITY_ALL) {
    $icon =  "far fa-eye";
}
?>
@if ($live && auth()->check())
    <i id="entity-file-{{ $model->id }}" class="{{ $icon }} pull-right margin-r-5 entity-file-visibility-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="{{ __('crud.visibilities.' . $model->visibility) }}"></i>
    <i id="entity-file-loading-{{ $model->id }}" class="pull-right margin-r-5 fa fa-spinner fa-spin hidden"></i>

    <ul class="pull-right margin-r-5 dropdown-menu" aria-labelledby="dLabel" data-target="entity-file-{{ $model->id }}" data-target-loading="entity-file-loading-{{ $model->id }}">
    <li>
        <a href="#" class="entity-file-visibility" data-url="{{ route('entities.entity_files.update', [$entity, $file]) }}" data-visibility="all" data-icon="far fa-eye" title="{{ __('crud.visibilities.all') }}">
            <i class="far fa-eye"></i>
            {{ __('crud.visibilities.all') }}
        </a>
    </li>
    <li>
        <a href="#" class="entity-file-visibility" data-url="{{ route('entities.entity_files.update', [$entity, $file]) }}" data-visibility="admin" data-icon="fas fa-lock" title="{{ __('crud.visibilities.admin') }}">
            <i class="fas fa-lock"></i> {{ __('crud.visibilities.admin') }}
        </a>
    </li>
    @if ($model->created_by == auth()->user()->id)
    <li>
        <a href="#" class="entity-file-visibility" data-url="{{ route('entities.entity_files.update', [$entity, $file]) }}" data-visibility="self" data-icon="fas fa-user-lock" title="{{ __('crud.visibilities.self') }}">
            <i class="fas fa-user-lock"></i>
            {{ __('crud.visibilities.self') }}
        </a>
    </li>
    @endif
</ul>
@else
    <i id="entity-file-{{ $model->id }}" class="{{ $icon }}" title="{{ __('crud.visibilities.' . $model->visibility) }}"></i>
@endif
