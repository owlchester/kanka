<div class="box box-solid" id="entity-descendants">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('entities.' . $entity->pluralType()) }}
        </h3>
        <div class="box-tools">
            @if (request()->has('parent_id'))
                <a href="{{ route('entities.descendants', [$campaign, $entity]) }}" class="btn btn-box-tool">
                    <i class="fa-solid fa-filter"></i> {{ __('crud.filters.all') }} ({{ $entity->child->descendants()->count() }})
                </a>
            @else
                <a href="{{ route('entities.descendants', [$campaign, $entity, 'parent_id' => $entity->entity_id]) }}" class="btn btn-box-tool">
                    <i class="fa-solid fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $entity->child->children()->count() }})
                </a>
            @endif
        </div>
    </div>

    <div id="datagrid-parent" class="table-responsive">
        @include('layouts.datagrid._table')
    </div>
</div>
