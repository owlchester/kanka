@if (Auth::user()->can('create', 'App\Models\Relation'))
    <p class="text-right">
        <a href="{{ route($name . '.relations.create', [$name => $model->id]) }}" class="btn btn-primary">
            {{ trans('crud.relations.actions.add') }}    </a>
    </p>
@endif

<table id="families" class="table table-hover">
    <tbody><tr>
        <th>{{ trans('crud.relations.fields.relation') }}</th>
        <th class="avatar"><br></th>
        <th>{{ trans('crud.relations.fields.name') }}</th>
        @if ($campaign->enabled('locations'))<th>{{ trans('crud.relations.fields.location') }}</th>@endif
        <th>&nbsp;</th>
    </tr>
    @foreach ($r = $model->entity->relationships()->has('target')->with('target')->paginate() as $relation)
        @if (empty($relation->target->child))
            <?php $relation->target->delete(); /* temp hack because some data was not deleted properly */ ?>
        @else
        <tr>
            <td>{{ $relation->relation }}</td>
            <td>
                <img class="direct-chat-img" src="{{ $relation->target->child->getImageUrl(true) }}" alt="{{ $relation->target->child->name }} picture">
            </td>
            <td>
                <a href="{{ route($relation->target->pluralType() . '.show', $relation->target->child->id) }}">{{ $relation->target->child->name }}</a>
            </td>
            @if ($campaign->enabled('locations'))<td>
                @if ($relation->target->child->location)
                    <a href="{{ route('locations.show', $relation->target->child->location_id) }}">{{ $relation->target->child->location->name }}</a>
                @endif
            </td>@endif
            <td class="text-right">
                @if (Auth::user()->can('update', $relation))
                    <a href="{{ route($name . '.relations.edit', [$name => $model, 'relation' => $relation]) }}" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> {{ trans('crud.edit') }}</a>
                @endif
                @if (Auth::user()->can('delete', $relation))
                {!! Form::open(['method' => 'DELETE', 'route' => [$name . '.relations.destroy', $name => $model, 'relation' => $relation], 'style'=>'display:inline']) !!}
                <button class="btn btn-xs btn-danger">
                    <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                </button>
                {!! Form::close() !!}
                @endif
            </td>
        </tr>
        @endif
    @endforeach
    </tbody></table>

{{ $r->appends('tab', 'relation')->links() }}
