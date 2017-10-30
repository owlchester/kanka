<p class="text-right">
    <a href="{{ route('family_relation.create', ['family' => $family->id]) }}" class="btn btn-primary">Add new relation</a>
</p>

<table id="families" class="table table-hover">
    <tbody><tr>
        <th>{{ trans('families.fields.relation') }}</th>
        <th>{{ trans('families.fields.name') }}</th>
        <th>{{ trans('families.fields.location') }}</th>
        <th>&nbsp;</th>
    </tr>
    @foreach ($r = $family->relationships()->paginate() as $relation)
        <tr>
            <td>{{ $relation->relation }}</td>
            <td><a href="{{ route('families.show', $relation->second_id) }}">{{ $relation->second->name }}</a></td>
            <td>
                @if ($relation->second->location)
                    <a href="{{ route('locations.show', $relation->second->location_id) }}">{{ $relation->second->location->name }}</a>
                @endif
            </td>
            <td class="text-right">
                {!! Form::open(['method' => 'DELETE','route' => ['family_relation.destroy', $relation->id],'style'=>'display:inline']) !!}
                <button class="btn btn-xs btn-danger">
                    <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                </button>
                {!! Form::close() !!}
            </td>
        </tr>
    @endforeach
    </tbody></table>

{{ $r->appends('tab', 'relation')->links() }}
