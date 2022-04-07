<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Relation $relation
 */?>
<div class="box box-solid box-entity-relations box-entity-relations-table" id="entity-relations-table">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('crud.tabs.relations') }}
        </h3>

        <div class="box-tools">
            <a href="#" class="btn btn-box-tool" data-toggle="modal" data-target="#help-modal">
                <i class="fa fa-question-circle"></i> {{ __('crud.actions.help') }}
            </a>
        </div>
    </div>
    <div class="box-body">

        @if ($relations->count() === 0)
        <p class="help-block">
            {{ __('entities/relations.helpers.no_relations') }}
        </p>
            @can('relation', [$entity->child, 'add'])
                <a href="{{ route('entities.relations.create', [$entity, 'mode' => $mode]) }}" class="btn btn-sm btn-warning" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.relations.create', [$entity, 'mode' => $mode]) }}">
                    <i class="fa fa-plus"></i>
                    <span class="hidden-xs hidden-sm">
                    {{ __('crud.relations.actions.add') }}
                </span>
                </a>
            @endcan
        @else

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
        @endif
    </div>
</div>


@includeWhen(!$connections->isEmpty(), 'entities.pages.relations._connections')


@section('modals')
    @parent
    <div class="modal fade" id="help-modal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">
                        {{ __('crud.actions.help') }}
                    </h4>
                </div>
                <div class="modal-body">
                    <p>
                        {{ __('entities/relations.helpers.popup') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
