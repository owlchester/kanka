<?php /** @var \App\Models\MiscModel $model */?>
<div class="entities-grid flex flex-wrap gap-2 lg:gap-5">
    @if (!empty($parent))
        <a href="{{ route($route . '.' . $sub, $parent->parent ? ['parent_id' => $parent->parent->id] : []) }}" class="entity block border w-48 overflow-hidden rounded">
            <div class="block h-36 flex items-center justify-center">
                <i class="fa-solid fa-arrow-left text-2xl" aria-hidden="true"></i>
            </div>
            <div class="block text-center p-4 h-12 border-t bg-box">
                @if ($parent->parent)
                {{ __('datagrids.actions.back_to', ['name' => $parent->parent->name]) }}
                @else
                    {{ __('crud.actions.back') }}
                @endif
            </div>
        </a>


        @include('cruds.datagrids._grid', ['model' => $parent, 'isParent' => true])
    @endif
    @foreach ($models as $model)
        @include('cruds.datagrids._grid')
    @endforeach
</div>


@if($models->hasPages())
    <div class="text-right">
        {{ $models->appends($filterService->pagination())->links() }}
    </div>
@endif
