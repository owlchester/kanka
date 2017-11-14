
@if (Auth::user()->can('create', \App\Models\LocationRelation::class))
<p class="text-right">
    <a href="{{ route('location_relation.create', ['location' => $location->id]) }}" class="btn btn-primary">
        {{ trans('locations.relations.actions.add') }}
    </a>
</p>
@endif

<table id="locations" class="table table-hover">
    <tbody><tr>
        <th>{{ trans('locations.fields.relation') }}</th>
        <th class="avatar"><br /></th>
        <th>{{ trans('locations.fields.name') }}</th>
        <th>{{ trans('locations.fields.type') }}</th>
        <th>{{ trans('locations.fields.location') }}</th>
        <th>&nbsp;</th>
    </tr>
    @foreach ($r = $location->relationships()->has('second')->with('second')->paginate() as $relation)
        <tr>
            <td>{{ $relation->relation }}</td>
            <td>
                <img class="direct-chat-img" src="{{ $relation->second->getImageUrl(true) }}" alt="{{ $relation->second->name }} picture">
            </td>
            <td>{{ $relation->type }}</td>
            <td>
                <a href="{{ route('locations.show', $relation->second_id) }}">{{ $relation->second->name }}</a></td>
            <td>
                @if ($relation->second->location)
                    <a href="{{ route('locations.show', $relation->second->location_id) }}">{{ $relation->second->location->name }}</a>
                @endif
            </td>
            <td class="text-right">
                @if (Auth::user()->can('delete', $relation))
                {!! Form::open(['method' => 'DELETE','route' => ['location_relation.destroy', $relation->id],'style'=>'display:inline']) !!}
                <button class="btn btn-xs btn-danger">
                    <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                </button>
                {!! Form::close() !!}
                @endif
            </td>
        </tr>
    @endforeach
    </tbody></table>

{{ $r->appends('tab', 'relation')->links() }}
