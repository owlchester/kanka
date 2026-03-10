<?php /**
 * @var \App\Models\MiscModel $model
 * @var \App\Models\EntityType $entityType
 * */?>
<div class="flex gap-1 items-start">
    <div class="entities-grid flex flex-wrap gap-3 lg:gap-5 w-full">
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
            @isset($entityType)
            <x-lists.empty-state :entityType="$entityType" :campaign="$campaign">
            </x-lists.empty-state>
            @else
            <p class="italic">
                {{ __('search.no_results') }}
            </p>
            @endif
        @endforelse
    </div>
</div>

@include('ads.inline')


@if($models instanceof \Illuminate\Pagination\LengthAwarePaginator && $models->hasPages())
        {{ $models
            ->appends(isset($filterService) ? $filterService->pagination() : (isset($term) ? ['term' => $term] : null))
            ->onEachSide(0)
            ->links(null, ['settingsLink' => base64_encode(route($route, $route === 'entities.index' ? [$campaign, $entityType] : $campaign))])
 }}
@endif
