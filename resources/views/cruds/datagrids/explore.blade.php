<?php /** @var \App\Models\MiscModel $model */?>
<div class="flex gap-1 items-start">
<div class="entities-grid flex flex-wrap gap-3 lg:gap-5">
    @if (!empty($parent))
        <a href="{{ route($route, array_merge($parent->parent ? [$campaign, 'parent_id' => $parent->parent->id] : [$campaign], isset($entityType) && $entityType->isCustom() ? ['entityType' => $entityType] : [])) }}" class="entity w-[47%] xs:w-[25%] sm:w-48 overflow-hidden rounded flex flex-col shadow-sm hover:shadow-md sm">
            <div class="w-46 flex items-center justify-center grow  text-6xl">
                <i class="fa-solid fa-arrow-left" aria-hidden="true"></i>
            </div>
            <div class="block text-center p-4 h-12 bg-box">
                @if ($parent->parent)
                {{ __('datagrids.actions.back_to', ['name' => $parent->parent->name]) }}
                @else
                    {{ __('crud.actions.back') }}
                @endif
            </div>
        </a>
        @includeWhen(!isset($entityType) || $entityType->isCustom(), 'entities.index._entity', ['model' => $parent, 'isParent' => true])
        @includeWhen(isset($entityType) && $entityType->isStandard(), 'cruds.datagrids._grid', ['model' => $parent, 'isParent' => true])
    @endif
    @forelse ($models as $model)
        @includeWhen(!isset($entityType) || $entityType->isCustom(), 'entities.index._entity')
        @includeWhen(isset($entityType) && $entityType->isStandard(), 'cruds.datagrids._grid')
    @empty
        <p class="italic">
            {{ __('search.no_results') }}
        </p>
    @endforelse

    @if (!isset($skipPaginationHelper) && auth()->check() && $models instanceof \Illuminate\Pagination\LengthAwarePaginator && $models->hasPages() && !UserCache::dismissedTutorial('pagination'))
        <div class="block border rounded shadow-xs hover:shadow-md w-48 overflow-hidden tutorial pagination-tutorial">
            <div class="bg-blue-100 h-48 w-48 overflow-hidden p-2 flex flex-col gap-2">
                <a class="grow" href="{{ route('settings.appearance', ['highlight' => 'pagination', 'from' => base64_encode(route($route, $route === 'entities.index' ? [$campaign, $entityType] : $campaign))]) }}">
                    {!! __('crud.helpers.pagination.text', ['settings' => __('crud.helpers.pagination.settings')]) !!}
                </a>

                <button type="button" class="btn2 btn-primary btn-sm btn-block" data-dismiss="tutorial" data-url="{{ route('tutorials.dismiss', ['code' => 'pagination']) }}" data-target=".pagination-tutorial">
                    {{ __('header.notifications.dismiss') }}
                </button>
            </div>

        </div>
    @endif
</div>
    @include('ads.siderail_right')
</div>


@if($models instanceof \Illuminate\Pagination\LengthAwarePaginator && $models->hasPages())
    <div class="text-right">
        {{ $models->appends(isset($filterService) ? $filterService->pagination() : (isset($term) ? ['term' => $term] : null))->onEachSide(0)->links() }}
    </div>
@endif
