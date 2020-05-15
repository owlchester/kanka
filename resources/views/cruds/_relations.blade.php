<?php
/**
 * @var \App\Models\MiscModel $model
 * @var \App\Models\Relation $relation
 */
$r = $model->entity->relationships()->has('target')->with(['target', 'target.tags'])->order(request()->get('order'))->paginate(); ?>
<p class="export-hidden">
    @can('relation', [$model, 'add'])
        <a href="{{ route($name . '.relations.create', [$name => $model->id]) }}" class="btn btn-primary btn-sm pull-right" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route($name . '.relations.create', [$name => $model->id]) }}">
            <i class="fa fa-plus"></i> <span class="hidden-xs hidden-sm">
                        {{ trans('crud.relations.actions.add') }}
                        </span></a>
    @endcan
    {{ trans('crud.relations.hint') }}
</p>
<p class="export-{{ ($r->count() === 0 ? 'visible export-hidden' : 'visible') }}">{{ trans('crud.tabs.relations') }}</p>

<table id="crud_families" class="table table-hover {{ ($r->count() === 0 ? 'export-hidden' : '') }}">
    <thead>
        <tr>
            <th>
                <a href="{{ route($name . '.show', [$model, 'order' => 'relations/relation', '#relations']) }}">
                    {{ trans('crud.relations.fields.relation') }}@if (request()->get('order') == 'relations/relation') <i class="fa fa-long-arrow-down"></i>@endif
                </a>
            </th>
            <th>
                <a href="{{ route($name . '.show', [$model, 'order' => 'relations/attitude', '#relations']) }}">
                    {{ trans('relations.fields.attitude') }}@if (request()->get('order') == 'relations/attitude') <i class="fa fa-long-arrow-down"></i>@endif
                </a>
            </th>
            <th class="avatar"><br></th>
            <th>
                <a href="{{ route($name . '.show', [$model, 'order' => 'relations/target.name', '#relations']) }}">
                    {{ trans('crud.relations.fields.name') }}@if (request()->get('order') == 'relations/target.name') <i class="fa fa-long-arrow-down"></i>@endif
                </a>
            </th>
            @if ($campaign->enabled('locations'))<th>{{ trans('crud.relations.fields.location') }}</th>@endif
            @if (Auth::check())
                <th>
                    <a href="{{ route($name . '.show', [$model, 'order' => 'relations/visibility', '#relations']) }}">
                        {{ trans('crud.fields.visibility') }}@if (request()->get('order') == 'relations/visibility') <i class="fa fa-long-arrow-down"></i>@endif
                    </a>
                </th>
            @endif
            <th class="text-right">
                <br />
            </th>
        </tr>
    </thead>
    <tbody>
    @foreach ($r as $relation)
        @viewentity($relation->target)
        <tr>
            <td class="breakable">{{ $relation->relation }}</td>
            <td class="breakable">{{ $relation->attitude }}</td>
            <td>
                <a class="entity-image" style="background-image: url('{{ $relation->target->child->getImageUrl(40) }}');" title="{{ $relation->target->child->name }}" href="{{ $relation->target->url() }}"></a>
            </td>
            <td>
                {!! $relation->target->tooltipedLink() !!}
            </td>
            @if ($campaign->enabled('locations'))<td>
                @if ($relation->target->child->location)
                    {!! $relation->target->child->location->tooltipedLink() !!}
                @endif
            </td>
            @endif
            @if (Auth::check())
                <td>
                    @include('cruds.partials.visibility', ['model' => $relation])
                </td>
            @endif
            <td class="text-right">
                @can('relation', [$model, 'edit'])
                    <a href="{{ route($name . '.relations.edit', [$name => $model, 'relation' => $relation]) }}" class="btn btn-xs btn-primary"
                       data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route($name . '.relations.edit', [$name => $model, 'relation' => $relation]) }}"
                       title=" {{ trans('crud.edit') }}"
                    >
                        <i class="fa fa-edit"></i>
                    </a>
                @endcan
                @can('relation', [$model, 'delete'])
                <button class="btn btn-xs btn-danger delete-confirm" data-toggle="modal" data-name="{{ $relation->target->name }}"
                        data-target="#delete-confirm" data-delete-target="delete-form-{{ $relation->id }}"
                        data-mirrored="{{ $relation->mirrored() }}"
                        title="{{ __('crud.remove') }}">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </button>
                {!! Form::open(['method' => 'DELETE', 'route' => [$name . '.relations.destroy', $name => $model, 'relation' => $relation], 'style' => 'display:inline', 'id' => 'delete-form-' . $relation->id]) !!}
                    {!! Form::hidden('remove_mirrored', 0) !!}
                {!! Form::close() !!}
                @endcan
            </td>
        </tr>
        @else
        <tr class="entity-hidden">
            <td colspan="{{ ($campaign->enabled('locations') ? 5 : 4) }}">{{ trans('crud.hidden') }}</td>
        </tr>
        @endviewentity
    @endforeach
    </tbody>
</table>

{{ $r->fragment('tab_relation')->links() }}
