<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Relation $relation
 */?>
<div class="box box-solid box-entity-relations box-entity-relations-table" id="entity-relations-table">
    <div class="box-header with-border">
        <h3 class="box-title">
            {{ __('crud.tabs.relations') }}
        </h3>
    </div>
    <div class="box-body">

        @if ($relations->count() === 0)
        <p class="help-block">
            {{ __('entities/relations.helper') }}
        </p>
        @endif

        <div class="row row-sorting">
            <div class="col-md-6">
                @include('cruds.datagrids.sorters.simple-sorter', [
    'filter' => !empty($mode) ? '?mode=' . $mode : null,
    'target' => '#entity-relations-table'
    ])
            </div>
            <div class="col-md-6 text-right">

            </div>
        </div>

        @include('entities.pages.relations._table')

        {{ $relations->appends(['mode' => $mode, 'dg-sort' => request()->get('dg-sort')])->fragment('entity-relations-table')->links() }}
    </div>
</div>


@includeWhen(!$connections->isEmpty(), 'entities.pages.relations._connections')

