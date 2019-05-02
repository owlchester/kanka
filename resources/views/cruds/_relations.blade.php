<?php $r = $model->entity->relationships()->has('target')->with(['target'])->order(request()->get('order'), 'relation')->paginate(); ?>
<p class="export-hidden">{{ trans('crud.relations.hint') }}</p>
<p class="export-{{ ($r->count() === 0 ? 'visible export-hidden' : 'visible') }}">{{ trans('crud.tabs.relations') }}</p>

<table id="crud_families" class="table table-hover {{ ($r->count() === 0 ? 'export-hidden' : '') }}">
    <thead>
        <tr>
            <th><a href="{{ route($name . '.show', [$model, 'order' => 'relations/relation', '#relations']) }}">{{ trans('crud.relations.fields.relation') }}@if (request()->get('order') == 'relations/relation') <i class="fa fa-long-arrow-down"></i>@endif</a></th>
            <th class="avatar"><br></th>
            <th><a href="{{ route($name . '.show', [$model, 'order' => 'relations/target.name', '#relations']) }}">{{ trans('crud.relations.fields.name') }}@if (request()->get('order') == 'relations/target.name') <i class="fa fa-long-arrow-down"></i>@endif</a></th>
            @if ($campaign->enabled('locations'))<th>{{ trans('crud.relations.fields.location') }}</th>@endif
            @if (Auth::check() && Auth::user()->isAdmin())
                <th><a href="{{ route($name . '.show', [$model, 'order' => 'relations/is_private', '#relations']) }}">{{ trans('crud.fields.is_private') }}@if (request()->get('order') == 'relations/is_private') <i class="fa fa-long-arrow-down"></i>@endif</a></th>
            @endif
            <th class="text-right">
                @can('relation', [$model, 'add'])
                    <a href="{{ route($name . '.relations.create', [$name => $model->id]) }}" class="btn btn-primary btn-sm" data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route($name . '.relations.create', [$name => $model->id]) }}">
                        <i class="fa fa-plus"></i> {{ trans('crud.relations.actions.add') }}    </a>
                @endcan
            </th>
        </tr>
    </thead>
    <tbody>
    @foreach ($r as $relation)
        @viewentity($relation->target)
        <tr>
            <td class="breakable">{{ $relation->relation }}</td>
            <td>
                <a class="entity-image" style="background-image: url('{{ $relation->target->child->getImageUrl(true) }}');" title="{{ $relation->target->child->name }}" href="{{ $relation->target->url() }}"></a>
            </td>
            <td>
                <a href="{{ $relation->target->url() }}" data-toggle="tooltip" title="{{ $relation->target->child->tooltipWithName() }}" data-html="true">
                    {{ $relation->target->child->name }}
                </a>
            </td>
            @if ($campaign->enabled('locations'))<td>
                @if ($relation->target->child->location)
                    <a href="{{ $relation->target->child->location->getLink() }}" data-toggle="tooltip" title="{{ $relation->target->child->location->tooltip() }}">{{ $relation->target->child->location->name }}</a>
                @endif
            </td>
            @endif
            @if (Auth::check() && Auth::user()->isAdmin())
                <td>
                    @if ($relation->is_private == true)
                        <i class="fas fa-lock" title="{{ trans('crud.is_private') }}"></i>
                    @endif
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
                        title="{{ __('crud.remove') }}">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </button>
                {!! Form::open(['method' => 'DELETE', 'route' => [$name . '.relations.destroy', $name => $model, 'relation' => $relation], 'style' => 'display:inline', 'id' => 'delete-form-' . $relation->id]) !!}
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
