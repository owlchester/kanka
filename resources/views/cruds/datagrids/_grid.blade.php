@php
    if (empty($model->entity)) {
        return;
    }
    $stacked = method_exists($model, 'children') && !isset($isParent) ? min(2, $model->children->count()) : null;
    //$model->entity->withChild($model);
@endphp
@if ($stacked > 0)
    <div class="stack inline-grid items-center align-items-end" data-stack="{{ $stacked }}">
        <div class="entity block border overflow-hidden rounded shadow-xs hover:shadow-md w-48" title="{{ $model->name }}">
            <a href="{{ route($route . '.' . $sub, ['m' => $mode ?? 'grid', 'parent_id' => $model->id]) }}"  class="block avatar h-36 relative cover-background overflow-hidden" style="background-image: url('{{ $model->entity->avatarSize(190, 144)->avatarV2($model) }}')">
                <div class="bg-box w-16 h-16 absolute -left-8 -top-8 rotate-45 banner-stacked"></div>
                <i class="fa-regular fa-folders absolute top-1 left-1 text-gray-800 text-base" aria-hidden="true" title="{{ __('datagrids.tooltips.nested') }}"></i>

                @if ($model->is_private)
                    <div class="bg-box w-16 h-16 absolute -right-8 -top-8 rotate-45 banner-private"></div>
                    <i class="fa-regular fa-lock absolute top-1 right-1 text-gray-800 text-base" aria-hidden="true" title="{{ __('crud.is_private') }}"></i>
                @endif
            </a>
            <a href="{{ $model->getLink() }}" class="block text-center relative truncate h-12 p-4 border-t bg-box"">
                {{ $model->name }}
            </a>
        </div>
        @for ($s = 0; $s < $stacked; $s++)
            <div class="entity block border w-48 overflow-hidden rounded">
                <div class="block h-36"></div>
                <div class="block h-12 p-4 border-t bg-box"></div>
            </div>
        @endfor
    </div>
@else
    <a href="{{ $model->getLink() }}" class="entity block border overflow-hidden rounded shadow-xs hover:shadow-md w-48 @if (isset($isParent)) shadow-lg stacking-parent font-bold @endif" title="{{ $model->name }}">
        <div class="avatar h-36 relative cover-background" style="background-image: url('{{ $model->entity->avatarSize(190, 144)->avatarV2($model) }}')">
            @if ($model->is_private)
                <div class="bg-box w-16 h-16 absolute -right-8 -top-8 rotate-45 banner-private"></div>
                <i class="fa-regular fa-lock absolute top-1 right-1 text-gray-800 text-base" aria-hidden="true" title="{{ __('crud.is_private') }}"></i>
            @endif
        </div>
        <div class="truncate text-center p-4 border-t bg-box h-12" data-toggle="tooltip-ajax" data-id="{{ $model->entity->id }}"
        data-url="{{ route('entities.tooltip', $model->entity->id) }}">
            {{ $model->name }}
        </div>
    </a>
@endif
