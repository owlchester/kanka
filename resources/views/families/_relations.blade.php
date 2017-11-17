@if (Auth::user()->can('create', 'App\Models\FamilyRelation'))
<p class="text-right">
    <a href="{{ route('families.family_relations.create', ['family' => $model->id]) }}" class="btn btn-primary">
        {{ trans('families.relations.actions.add') }}    </a>
</p>
@endif

<table id="families" class="table table-hover">
    <tbody><tr>
        <th>{{ trans('families.fields.relation') }}</th>
        <th class="avatar"><br></th>
        <th>{{ trans('families.fields.name') }}</th>
        @if ($campaign->enabled('locations'))<th>{{ trans('families.fields.location') }}</th>@endif
        <th>&nbsp;</th>
    </tr>
    @foreach ($r = $model->relationships()->has('second')->with('second')->paginate() as $relation)
        <tr>
            <td>{{ $relation->relation }}</td>
            <td>
                <img class="direct-chat-img" src="{{ $relation->second->getImageUrl(true) }}" alt="{{ $relation->second->name }} picture">
            </td>
            <td>
                <a href="{{ route('families.show', $relation->second_id) }}">{{ $relation->second->name }}</a>
            </td>
            @if ($campaign->enabled('locations'))
            <td>
                @if ($relation->second->location)
                    <a href="{{ route('locations.show', $relation->second->location_id) }}">{{ $relation->second->location->name }}</a>
                @endif
            </td>
            @endif
            <td class="text-right">
                @if (Auth::user()->can('update', $relation))
                    <a href="{{ route('families.family_relations.edit', ['family' => $model, 'familyRelation' => $relation]) }}" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> {{ trans('crud.edit') }}</a>
                @endif
                @if (Auth::user()->can('delete', $relation))
                {!! Form::open(['method' => 'DELETE', 'route' => ['families.family_relations.destroy', 'family' => $model, 'familyRelation' => $relation], 'style'=>'display:inline']) !!}
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
