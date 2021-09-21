<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Relation $relation
 */?>
<div class="box box-solid box-entity-relations box-entity-relations-table" id="entity-relations-table">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ __('crud.tabs.relations') }}
        </h2>

        <p class="help-block export-hidden">
            {{ __('entities/relations.helper') }}
        </p>

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

