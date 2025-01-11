@php
    if ($model->child) {
        $model = $model->child;
    }
    if (empty($model->entity)) {
        return;
    }
    $stacked = !isset($flat) && method_exists($model, 'children') && !isset($isParent) ? min(2, $model->children->count()) : null;
    $dataAttributes = [];
    if ($model->is_private) {
        $dataAttributes[] = 'private';
    }
    if ($model instanceof \App\Models\Character && $model->isDead()) {
        $dataAttributes[] = 'dead';
    } elseif ($model instanceof \App\Models\Organisation && $model->isDefunct()) {
        $dataAttributes[] = 'defunct';
    } elseif ($model instanceof \App\Models\Creature && $model->isExtinct()) {
        $dataAttributes[] = 'extinct';
    } elseif ($model instanceof \App\Models\Quest && $model->isCompleted()) {
        $dataAttributes[] = 'completed';
    }
@endphp
@if ($stacked > 0)
    <div class="stack inline-grid items-center align-items-end w-[47%] xs:w-[25%] sm:w-48 " data-stack="{{ $stacked }}">
        <div class="entity overflow-hidden rounded shadow-sm hover:shadow-md aspect-square w-full flex flex-col bg-box" title="{{ $model->name }}" @foreach ($dataAttributes as $att) data-{{ $att }}="true" @endforeach data-entity="{{ $model->entity->id }}" data-entity-type="{{ $model->entity->entityType->code }}" @if (!empty($model->type)) data-type="{{ \Illuminate\Support\Str::slug($model->type) }}" @endif>
            <a href="{{ route($route, [$campaign, 'parent_id' => $model->id]) }}"  class="block avatar grow relative cover-background overflow-hidden text-center" style="background-image: url('{{ Avatar::entity($model->entity)->fallback()->size(192, 144)->thumbnail() }}')">

                @if ($model->is_private)
                    <div class="bubble-private absolute left-1.5 top-1.5 text-base shadow-xs flex justify-center align-items-center items-center aspect-square rounded-full w-6 h-6 bg-box opacity-80">
                        <x-icon class="fa-regular fa-lock" :title="__('crud.is_private')" />
                    </div>
                @endif
            </a>
            @if ($model instanceof \App\Models\Map && $model->explorable())
                <div class="flex items-center" data-toggle="tooltip-ajax"  data-id="{{ $model->entity->id }}" data-url="{{ route('entities.tooltip', [$campaign, $model->entity->id]) }}">
                    <a href="{{ $model->getLink() }}" class="block text-center relative truncate h-12 px-2 py-4 grow">
                        {!! $model->name !!}
                    </a>
                    <a href="{{ $model->getLink('explore') }}" class="block text-center h-12 p-4" target="_blank" title="{{ __('maps.actions.explore') }}">
                        <x-icon class="fa-regular fa-map" />
                        <span class="sr-only">{{ __('maps.actions.explore') }}</span>
                    </a>
                </div>
            @else
            <a href="{{ $model->getLink() }}" class="block text-center relative truncate h-12 p-4" data-toggle="tooltip-ajax" data-id="{{ $model->entity->id }}"
               data-url="{{ route('entities.tooltip', [$campaign, $model->entity->id]) }}">
                {!! $model->name !!}
            </a>
            @endif
        </div>
        @for ($s = 0; $s < $stacked; $s++)
            <div class="entity entity-stack bg-base-300 w-full overflow-hidden rounded aspect-square flex flex-col shadow-sm" title="{{ __('datagrids.tooltips.nested') }}" data-stack="{{ $s }}">
                <div class="block grow"></div>
                <div class="block h-12 p-4 bg-box"></div>
            </div>
        @endfor
    </div>
@else
    <div class="entity overflow-hidden rounded shadow-sm hover:shadow-md w-[47%] xs:w-[25%] sm:w-48 aspect-square flex flex-col bg-box @if (isset($isParent)) shadow-lg stacking-parent font-bold @endif" title="{{ $model->name }}" @foreach ($dataAttributes as $att) data-{{ $att }}="true" @endforeach data-entity="{{ $model->entity->id }}" data-entity-type="{{ $model->entity->entityType->code }}" @if (!empty($model->type)) data-type="{{ \Illuminate\Support\Str::slug($model->type) }}" @endif>
        <a href="{{ $model->getLink() }}" class="block avatar grow relative cover-background" style="background-image: url('{{ Avatar::entity($model->entity)->fallback()->size(192, 144)->thumbnail() }}')">
            @if ($model->is_private)
                <div class="bubble-private absolute left-1.5 top-1.5 shadow-xs flex justify-center align-items-center items-center aspect-square rounded-full w-6 h-6 text-xs bg-box opacity-80">
                    <x-icon class="fa-regular fa-lock" :title="__('crud.is_private')" />
                </div>
            @endif
        </a>
        @if ($model instanceof \App\Models\Map && $model->explorable())
            <div class="flex items-center" data-toggle="tooltip-ajax"  data-id="{{ $model->entity->id }}" data-url="{{ route('entities.tooltip', [$campaign, $model->entity->id]) }}">
                <a href="{{ $model->getLink() }}" class="block text-center relative truncate h-12 px-2 py-4 grow" >
                    {!! $model->name !!}
                </a>
                <a href="{{ $model->getLink('explore') }}" class="block text-center h-12 p-4" target="_blank" title="{{ __('maps.actions.explore') }}">
                    <x-icon class="fa-regular fa-map" />
                    <span class="sr-only">{{ __('maps.actions.explore') }}</span>
                </a>
            </div>
        @else
        <a href="{{ $model->getLink() }}" class="block truncate text-center px-2 py-4 h-12" data-toggle="tooltip-ajax" data-id="{{ $model->entity->id }}"
        data-url="{{ route('entities.tooltip', [$campaign, $model->entity->id]) }}">
            {!! $model->name !!}
        </a>
        @endif
    </div>
@endif
