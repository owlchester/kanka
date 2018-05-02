<p>{{ trans('characters.organisations.hint') }}</p>
<table id="organisations" class="table table-hover">
    <tbody><tr>
        <th class="avatar"></th>
        <th>{{ trans('organisations.fields.name') }}</th>
        <th>{{ trans('organisations.members.fields.role') }}</th>
        <th class="pull-right">
            @can('organisation', [$model, 'add'])
                <a href="{{ route('characters.character_organisations.create', ['character' => $model->id]) }}" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i> {{ trans('characters.organisations.actions.add') }}
                </a>
            @endcan
        </th>
    </tr>
    @foreach ($r = $model->organisations()->has('organisation')->with('organisation')->paginate() as $relation)
        <tr>
            <td>
                <a class="entity-image" style="background-image: url('{{ $relation->organisation->getImageUrl(true) }}');" title="{{ $relation->organisation->name }}" href="{{ route('organisations.show', $relation->organisation->id) }}"></a>
            </td>
            <td>
                <a href="{{ route('organisations.show', $relation->organisation_id) }}" data-toggle="tooltip" title="{{ $relation->organisation->tooltip() }}">{{ $relation->organisation->name }}</a>
            </td>
            <td>{{ $relation->role }}</td>
            <td class="text-right">
                @can('organisation', [$model, 'edit'])
                    <a href="{{ route('characters.character_organisations.edit', ['character' => $model, 'organisationMember' => $relation]) }}" class="btn btn-xs btn-primary">
                        <i class="fa fa-pencil"></i> {{ trans('crud.edit') }}
                    </a>
                @endcan
                @can('organisation', [$model, 'delete'])
                {!! Form::open(['method' => 'DELETE','route' => ['characters.character_organisations.destroy', $model->id, $relation->id],'style'=>'display:inline']) !!}
                <button class="btn btn-xs btn-danger">
                    <i class="fa fa-trash" aria-hidden="true"></i> {{ trans('crud.remove') }}
                </button>
                {!! Form::close() !!}
                @endcan
            </td>
        </tr>
    @endforeach
    </tbody></table>

{{ $r->fragment('tab_relation')->links() }}
