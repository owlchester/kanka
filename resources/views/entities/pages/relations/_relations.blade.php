<?php /** @var \App\Models\Entity $entity
 * @var \App\Models\Relation $relation
 */?>
<div class="flex gap-2">
    <h3 class="grow box-title">
        {{ __('sidebar.relations') }}
    </h3>
</div>
<x-box css="box-entity-relations box-entity-relations-table" id="entity-relations-table" :padding="$rows->count() === 0">
    @if ($rows->count() === 0)
        <p class="help-block">
            {{ __('entities/relations.helpers.no_relations') }}
        </p>
        @can('relation', [$entity->child, 'add'])
            <a href="{{ route('entities.relations.create', [$campaign, $entity, 'mode' => $mode]) }}" class="btn2 btn-sm btn-accent" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.relations.create', [$campaign, $entity, 'mode' => $mode]) }}">
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
</x-box>

@includeWhen(!$connections->isEmpty(), 'entities.pages.relations._connections')


@section('modals')
    @parent

    @include('layouts.datagrid.delete-forms', ['models' => Datagrid::deleteForms(), 'params' => []])
@endsection

@section('scripts')
    @vite('resources/js/relations.js')
@endsection

@section('styles')
    @vite('resources/sass/relations.scss')
@endsection
