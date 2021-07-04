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
        @include('cruds.datagrids.sorters.simple-sorter', ['filter' => !empty($mode) ? '?mode=' . $mode : null, 'target' => '#entity-relations-table'])
    </div>
    <div class="col-md-6 text-right">

    </div>
</div>

<table id="entity_relations" class="table table-hover {{ ($relations->count() === 0 ? 'export-hidden' : '') }}">
    <thead>
    <tr>
        <th>
            {{ __('entities/relations.fields.relation') }}
        </th>
        <th class="avatar"><br></th>
        <th>
            {{ __('crud.relations.fields.name') }}
        </th>
        <th class="hidden-xs hidden-sm">
            {{ __('crud.fields.location') }}
        </th>
        <th class="hidden-xs hidden-sm">
            {{ __('entities/relations.fields.attitude') }}
        </th>
        @if (Auth::check())
            <th>
                <span class="hidden-xs hidden-sm">
                {{ __('crud.fields.visibility') }}
                </span>
            </th>
        @endif
        <th class="text-right">
            <br />
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach ($relations as $relation)
        @viewentity($relation->target)
        <tr>
            <td class="breakable">
                {{ $relation->relation }}
            </td>
            <td>
                <a class="entity-image" style="background-image: url('{{ $relation->target->child->getImageUrl(40) }}');" title="{{ $relation->target->child->name }}" href="{{ $relation->target->url() }}"></a>
            </td>
            <td>
                {!! $relation->target->tooltipedLink() !!}
            </td>
            <td class="hidden-xs hidden-sm">
                @if (isset($relation->target->child->location_id) && !empty($relation->target->child->location))
                    {!! $relation->target->child->location->tooltipedLink() !!}
                @endif
            </td>
            <td class="breakable hidden-xs hidden-sm">
                @if (!empty($relation->colour))
                    <div class="label-tag-bubble" style="background-color: {{ $relation->colour }}"></div>
                @endif
                {{ $relation->attitude }}
            </td>
            @if (Auth::check())
                <td>
                    @include('cruds.partials.visibility', ['model' => $relation])
                </td>
            @endif
            <td class="text-right">
                @can('relation', [$entity->child, 'edit'])
                    <a href="{{ route('entities.relations.edit', [$entity, 'relation' => $relation, 'mode' => 'table']) }}" class="btn btn-xs btn-primary"
                       data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('entities.relations.edit', [$entity, 'relation' => $relation, 'mode' => 'table']) }}"
                       title=" {{ __('crud.edit') }}"
                    >
                        <i class="fa fa-edit"></i>
                    </a>
                @endcan
                @can('relation', [$entity->child, 'delete'])
                    <button class="btn btn-xs btn-danger delete-confirm" data-toggle="modal" data-name="{{ $relation->target->name }}"
                            data-target="#delete-confirm" data-delete-target="delete-form-{{ $relation->id }}"
                            data-mirrored="{{ $relation->mirrored() }}"
                            title="{{ __('crud.remove') }}">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                    {!! Form::open(['method' => 'DELETE', 'route' => ['entities.relations.destroy', $entity, 'relation' => $relation], 'style' => 'display:inline', 'id' => 'delete-form-' . $relation->id]) !!}
                    {!! Form::hidden('remove_mirrored', 0) !!}
                    {!! Form::close() !!}
                @endcan
            </td>
        </tr>
        @else
            <tr class="entity-hidden">
                <td colspan="{{ ($campaign->enabled('locations') ? 5 : 4) }}">{{ __('crud.hidden') }}</td>
            </tr>
        @endviewentity
    @endforeach
    </tbody>
</table>

{{ $relations->appends(['mode' => $mode, 'dg-sort' => request()->get('dg-sort')])->fragment('entity-relations-table')->links() }}
    </div>
</div>


@includeWhen(!$connections->isEmpty(), 'entities.pages.relations._connections')
