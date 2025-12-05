<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Relation $relation
 */?>
<h3 class="text-xl">
    {{ __('sidebar.relations') }}
</h3>
<x-box class="box-entity-relations box-entity-relations-table" id="entity-relations-table" :padding="$rows->count() === 0">
    @if ($rows->count() === 0)
        <x-helper>
            <p>{{ __('entities/relations.helpers.no_relations') }}</p>
        </x-helper>
        @can('relation', $entity)
            <a href="{{ route('entities.relations.create', [$campaign, $entity, 'mode' => $mode]) }}" class="btn2 btn-sm btn-outline" data-toggle="dialog" data-target="primary-dialog" data-url="{{ route('entities.relations.create', [$campaign, $entity, 'mode' => $mode]) }}">
                <x-icon class="plus" />
                <span class="hidden md:inline">
                {{ __('entities.relation') }}
            </span>
            </a>
        @endcan
    @else
        <div id="datagrid-parent" class="table-responsive">
            @include('layouts.datagrid._table')
        </div>
    @endif
</x-box>

@includeWhen(!$connections->isEmpty(), 'entities.pages.relations._related')

@section('modals')
    @parent
    <x-dialog id="edit-dialog" :loading="true" />
    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms(), 'params' => []])
@endsection
