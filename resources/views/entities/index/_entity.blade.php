@php
/** @var \App\Models\Entity $model */
    $stacked = !isset($flat) && !isset($isParent) ? min(2, $model->children_count) : null;
    $dataAttributes = [];
    if ($model->is_private) {
        $dataAttributes[] = 'private';
    }
@endphp
@if ($stacked > 0)
    <div class="stack inline-grid items-center align-items-end w-[47%] xs:w-[25%] sm:w-48 " data-stack="{{ $stacked }}">
        <div class="entity overflow-hidden rounded shadow-sm hover:shadow-md aspect-square w-full flex flex-col bg-box" title="{{ $model->name }}" @foreach ($dataAttributes as $att) data-{{ $att }}="true" @endforeach data-entity="{{ $model->id }}" data-entity-type="{{ $model->entityType->code }}" @if (!empty($model->type)) data-type="{{ \Illuminate\Support\Str::slug($model->type) }}" @endif>
            <a href="{{ route('entities.index', [$campaign, $entityType, 'parent_id' => $model->id]) }}"  class="block avatar grow relative cover-background overflow-hidden text-center" style="background-image: url('{{ Avatar::entity($model)->fallback()->size(192, 144)->thumbnail() }}')">

                @if ($model->is_private)
                    <div class="bubble-private absolute left-1.5 top-1.5 text-base shadow-xs flex justify-center align-items-center items-center aspect-square rounded-full w-6 h-6 bg-box opacity-80 text-base-content">
                        <x-icon class="lock" :title="__('crud.is_private')" />
                    </div>
                @endif
            </a>
            <a href="{{ $model->url() }}" class="block text-center relative truncate h-12 p-4" data-toggle="tooltip-ajax" data-id="{{ $model->id }}"
               data-url="{{ route('entities.tooltip', [$campaign, $model->id]) }}">
                {!! $model->name !!}
            </a>
        </div>
        @for ($s = 0; $s < $stacked; $s++)
            <div class="entity entity-stack bg-base-300 w-full overflow-hidden rounded aspect-square flex flex-col shadow-sm" title="{{ __('datagrids.tooltips.nested') }}" data-stack="{{ $s }}">
                <div class="block grow"></div>
                <div class="block h-12 p-4 bg-box"></div>
            </div>
        @endfor
    </div>
@else
    <div class="entity overflow-hidden rounded shadow-sm hover:shadow-md w-[47%] xs:w-[25%] sm:w-48 aspect-square flex flex-col bg-box @if (isset($isParent)) shadow-lg stacking-parent font-bold @endif" title="{{ $model->name }}" @foreach ($dataAttributes as $att) data-{{ $att }}="true" @endforeach data-entity="{{ $model->id }}" data-entity-type="{{ $model->entityType->code }}" @if (!empty($model->type)) data-type="{{ \Illuminate\Support\Str::slug($model->type) }}" @endif>
        <a href="{{ $model->url() }}" class="block avatar grow relative cover-background" style="background-image: url('{{ Avatar::entity($model)->fallback()->size(192, 144)->thumbnail() }}')">
            @if ($model->is_private)
                <div class="bubble-private absolute left-1.5 top-1.5 shadow-xs flex justify-center align-items-center items-center aspect-square rounded-full w-6 h-6 text-base bg-box opacity-80 text-base-content">
                    <x-icon class="lock" :title="__('crud.is_private')" />
                </div>
            @endif
        </a>
        <a href="{{ $model->url() }}" class="block truncate text-center px-2 py-4 h-12" data-toggle="tooltip-ajax" data-id="{{ $model->id }}"
        data-url="{{ route('entities.tooltip', [$campaign, $model->id]) }}">
            {!! $model->name !!}
        </a>
    </div>
@endif
