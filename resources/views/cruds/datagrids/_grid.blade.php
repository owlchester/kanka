@php
    if (empty($model->entity)) {
        return;
    }
    $stacked = method_exists($model, 'children') && !isset($isParent) ? min(2, $model->children->count()) : null;
    $dataAttributes = [];
    if ($model->is_private) {
        $dataAttributes[] = 'private';
    }
    if ($model instanceof \App\Models\Character && $model->isDead()) {
        $dataAttributes[] = 'dead';
    } elseif ($model instanceof \App\Models\Organisation && $model->isDefunct()) {
        $dataAttributes[] = 'defunct';
    } elseif ($model instanceof \App\Models\Quest && $model->isComplete()) {
        $dataAttributes[] = 'defunct';
    }
@endphp
@if ($stacked > 0)
    <div class="stack inline-grid items-center align-items-end w-[47%] xs:w-[25%] sm:w-48 " data-stack="{{ $stacked }}">
        <div class="entity block border overflow-hidden rounded shadow-xs hover:shadow-md aspect-square w-full flex flex-col bg-box" title="{{ $model->name }}" @foreach ($dataAttributes as $att) data-{{ $att }}="true" @endforeach data-entity="{{ $model->entity->id }}" data-entity-type="{{ $model->getEntityType() }}">
            <a href="{{ route($route . '.' . $sub, ['m' => $mode ?? 'grid', 'parent_id' => $model->id]) }}"  class="block avatar grow relative cover-background overflow-hidden text-center" style="background-image: url('{{ $model->entity->avatarSize(190, 144)->avatarV2($model) }}')">
{{--                <div class="bg-box w-16 h-16 absolute -left-8 -top-8 rotate-45 banner-stacked"></div>--}}
                <div class="bubble-nested rounded bg-box opacity-95 absolute left-1 top-1 text-base p-1 w-8 h-8">
                <i class="fa-regular fa-folders text-gray-800" aria-hidden="true" title="{{ __('datagrids.tooltips.nested') }}"></i>
                </div>

                @if ($model->is_private)
                    <div class="bubble-private rounded  absolute right-1 top-1 text-base drop-shadow-lg shadow-white">
                        <i class="fa-regular fa-lock text-gray-800" aria-hidden="true" title="{{ __('crud.is_private') }}"></i>
                    </div>
                @endif
            </a>
            @if ($model instanceof \App\Models\Map && $model->explorable())
                <div class="flex items-center border-t">
                    <a href="{{ $model->getLink() }}" class="block text-center relative truncate h-12 px-2 py-4 grow">
                        {!! $model->name !!}
                    </a>
                    <a href="{{ $model->getLink('explore') }}" class="block text-center h-12 p-4 border-l" target="_blank" title="{{ __('maps.actions.explore') }}">
                        <i class="fa-solid fa-map" aria-hidden="true"></i>
                        <span class="sr-only">{{ __('maps.actions.explore') }}</span>
                    </a>
                </div>
            @else
            <a href="{{ $model->getLink() }}" class="block text-center relative truncate h-12 p-4 border-t">
                {!! $model->name !!}
            </a>
            @endif
        </div>
        @for ($s = 0; $s < $stacked; $s++)
            <div class="entity block border w-full overflow-hidden rounded aspect-square flex flex-col">
                <div class="block grow"></div>
                <div class="block h-12 p-4 border-t bg-box"></div>
            </div>
        @endfor
    </div>
@else
    <div class="entity block border overflow-hidden rounded shadow-xs hover:shadow-md w-[47%] xs:w-[25%] sm:w-48 aspect-square flex flex-col bg-box @if (isset($isParent)) shadow-lg stacking-parent font-bold @endif" title="{{ $model->name }}" @foreach ($dataAttributes as $att) data-{{ $att }}="true" @endforeach data-entity="{{ $model->entity->id }}" data-entity-type="{{ $model->getEntityType() }}">
        <a href="{{ $model->getLink() }}" class="block avatar grow relative cover-background" style="background-image: url('{{ $model->entity->avatarSize(190, 144)->avatarV2($model) }}')">
            @if ($model->is_private)
                <div class="bg-box w-16 h-16 absolute -right-8 -top-8 rotate-45 banner-private"></div>
                <i class="fa-regular fa-lock absolute top-1 right-1 text-gray-800 text-base" aria-hidden="true" title="{{ __('crud.is_private') }}"></i>
            @endif
        </a>
        @if ($model instanceof \App\Models\Map && $model->explorable())
            <div class="flex items-center border-t">
                <a href="{{ $model->getLink() }}" class="block text-center relative truncate h-12 px-2 py-4 grow">
                    {!! $model->name !!}
                </a>
                <a href="{{ $model->getLink('explore') }}" class="block text-center h-12 p-4 border-l" target="_blank" title="{{ __('maps.actions.explore') }}">
                    <i class="fa-solid fa-map" aria-hidden="true"></i>
                    <span class="sr-only">{{ __('maps.actions.explore') }}</span>
                </a>
            </div>
        @else
        <a href="{{ $model->getLink() }}" class="block truncate text-center px-2 py-4 border-t h-12" data-toggle="tooltip-ajax" data-id="{{ $model->entity->id }}"
        data-url="{{ route('entities.tooltip', $model->entity->id) }}">
            {!! $model->name !!}
        </a>
        @endif
    </div>
@endif
