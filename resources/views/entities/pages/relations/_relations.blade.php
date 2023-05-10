<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Relation $relation
 */?>
<div class="flex gap-2">
    <h3 class="grow box-title">
        {{ __('sidebar.relations') }}
    </h3>

    <div class="flex-0">
        <a href="#" class="btn btn-default btn-sm" data-toggle="dialog" data-target="help-modal">
            <x-icon class="question"></x-icon> {{ __('crud.actions.help') }}
        </a>
    </div>
</div>
<div class="box box-solid box-entity-relations box-entity-relations-table" id="entity-relations-table">
    <div class="box-body @if ($rows->count() > 0) no-padding @endif">

        @if ($rows->count() === 0)
            <p class="help-block">
                {{ __('entities/relations.helpers.no_relations') }}
            </p>
            @can('relation', [$entity->child, 'add'])
                <a href="{{ route('entities.relations.create', [$entity, 'mode' => $mode]) }}" class="btn btn-sm btn-warning" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.relations.create', [$entity, 'mode' => $mode]) }}">
                    <x-icon class="plus"></x-icon>
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
