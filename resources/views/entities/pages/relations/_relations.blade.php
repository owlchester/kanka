<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Relation $relation
 */?>
<div class="box box-solid box-entity-relations box-entity-relations-table" id="entity-relations-table">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('crud.tabs.relations') }}
        </h3>

        <div class="box-tools">
            <a href="#" class="btn btn-box-tool" data-toggle="dialog" data-target="help-modal">
                <i class="fa-solid fa-question-circle"></i> {{ __('crud.actions.help') }}
            </a>
        </div>
    </div>
    <div class="box-body">

        @if ($rows->count() === 0)
            <p class="help-block">
                {{ __('entities/relations.helpers.no_relations') }}
            </p>
            @can('relation', [$entity->child, 'add'])
                <a href="{{ route('entities.relations.create', [$entity, 'mode' => $mode]) }}" class="btn btn-sm btn-warning" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.relations.create', [$entity, 'mode' => $mode]) }}">
                    <i class="fa-solid fa-plus"></i>
                    <span class="hidden-xs hidden-sm">
                    {{ __('entities.relation') }}
                </span>
                </a>
            @endcan
        @else

            <div id="datagrid-parent" class="table-responsive">
                @include('layouts.datagrid._table')
            </div>
        @endif
    </div>
</div>

@includeWhen(!$connections->isEmpty(), 'entities.pages.relations._connections')


@section('modals')
    @parent
    @include('partials.helper-modal', [
        'id' => 'help-modal',
        'title' => __('crud.actions.help'),
        'textes' => [
            __('entities/relations.helpers.popup')
        ]
    ])

    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms(), 'params' => []])
@endsection
