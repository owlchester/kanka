
@if (Auth::user()->can('create', \App\Models\OrganisationRelation::class))
<p class="text-right">
    <a href="{{ route('organisation_relation.create', ['organisation' => $organisation->id]) }}" class="btn btn-primary">
        {{ trans('organisations.relations.actions.add') }}
    </a>
</p>
@endif

<table id="organisations" class="table table-hover">
    <tbody><tr>
        <th>{{ trans('organisations.fields.relation') }}</th>
        <th class="avatar"><br /></th>
        <th>{{ trans('organisations.fields.name') }}</th>
        <th>{{ trans('organisations.fields.type') }}</th>
        <th>{{ trans('organisations.fields.location') }}</th>
        <th>&nbsp;</th>
    </tr>
    @foreach ($r = $organisation->relationships()->has('second')->with('second')->paginate() as $relation)
        <tr>
            <td>{{ $relation->relation }}</td>
            <td>
                <img class="direct-chat-img" src="{{ $relation->second->getImageUrl(true) }}" alt="{{ $relation->second->name }} picture">
            </td>
            <td>{{ $relation->type }}</td>
            <td>
                <a href="{{ route('organisations.show', $relation->second_id) }}">{{ $relation->second->name }}</a></td>
            <td>
                @if ($relation->second->location)
                    <a href="{{ route('locations.show', $relation->second->location_id) }}">{{ $relation->second->location->name }}</a>
                @endif
            </td>
            <td class="text-right">
                @if (Auth::user()->can('delete', $relation))
                {!! Form::open(['method' => 'DELETE','route' => ['organisation_relation.destroy', $relation->id],'style'=>'display:inline']) !!}
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
