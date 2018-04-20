@can('relation', [$model, 'add'])
    <p class="text-right">
        <a href="{{ route($name . '.relations.create', [$name => $model->id]) }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> {{ trans('crud.relations.actions.add') }}    </a>
    </p>
@endcan

<table id="crud_families" class="table table-hover">
    <tbody><tr>
        <th>{{ trans('crud.relations.fields.relation') }}</th>
        <th class="avatar"><br></th>
        <th>{{ trans('crud.relations.fields.name') }}</th>
        @if ($campaign->enabled('locations'))<th>{{ trans('crud.relations.fields.location') }}</th>@endif
        <th>&nbsp;</th>
    </tr>
    @foreach ($r = $model->entity->relationships()->has('target')->with('target')->paginate() as $relation)
        @can('view', $relation->target->child)
        <tr>
            <td>{{ $relation->relation }}</td>
            <td>
                <a class="entity-image" style="background-image: url('{{ $relation->target->child->getImageUrl(true) }}');" title="{{ $relation->target->child->name }}" href="{{ route('characters.show', $relation->target->child->id) }}"></a>
            </td>
            <td>
                <a href="{{ route($relation->target->pluralType() . '.show', $relation->target->child->id) }}" data-toggle="tooltip" title="{{ $relation->target->child->tooltip() }}">
                    {{ $relation->target->child->name }}
                </a>
            </td>
            @if ($campaign->enabled('locations'))<td>
                @if ($relation->target->child->location)
                    <a href="{{ route('locations.show', $relation->target->child->location_id) }}" data-toggle="tooltip" title="{{ $relation->target->child->location->tooltip() }}">{{ $relation->target->child->location->name }}</a>
                @endif
            </td>@endif
            <td class="text-right">
                @can('relation', [$model, 'edit'])
                    <a href="{{ route($name . '.relations.edit', [$name => $model, 'relation' => $relation]) }}" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> {{ trans('crud.edit') }}</a>
                @endcan
                @can('relation', [$model, 'delete'])
                {!! Form::open(['method' => 'DELETE', 'route' => [$name . '.relations.destroy', $name => $model, 'relation' => $relation], 'style'=>'display:inline']) !!}
                <button class="btn btn-xs btn-danger">
                    <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                </button>
                {!! Form::close() !!}
                @endcan
            </td>
        </tr>
        @else
        <tr class="entity-hidden">
            <td colspan="{{ ($campaign->enabled('locations') ? 5 : 4) }}">{{ trans('crud.hidden') }}</td>
        </tr>
        @endcan
    @endforeach
    </tbody></table>

{{ $r->fragment('tab_relation')->links() }}
