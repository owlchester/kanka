<div class="box box-flat">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('characters.show.tabs.organisations') }}
        </h2>

        <?php  $r = $model->organisations()->organisationAcl()->orderBy('role', 'ASC')->has('organisation')->with(['organisation', 'organisation.location'])->paginate(); ?>
        <table id="character-organisations" class="table table-hover {{ $r->count() === 0 ? 'export-hidden' : '' }}">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ trans('organisations.fields.name') }}</th>
                <th class="visible-sm">{{ trans('organisations.fields.type') }}</th>
                <th>{{ trans('organisations.members.fields.role') }}</th>
                @if ($campaign->enabled('locations'))
                    <th class="visible-sm">{{ trans('crud.fields.location') }}</th>
                @endif
                <th class="text-right">
                    @can('organisation', [$model, 'add'])
                        <a href="{{ route('characters.character_organisations.create', ['character' => $model->id]) }}" class="btn btn-primary btn-sm" data-toggle="ajax-modal"
                           data-target="#entity-modal" data-url="{{ route('characters.character_organisations.create', $model->id) }}">
                            <i class="fa fa-plus"></i>
                        </a>
                    @endcan
                </th>
            </tr>
            @foreach ($r as $organisation)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $organisation->organisation->getImageUrl(true) }}');" title="{{ $organisation->organisation->name }}" href="{{ route('organisations.show', $organisation->organisation->id) }}"></a>
                    </td>
                    <td>
                        <a href="{{ route('organisations.show', $organisation->organisation_id) }}" data-toggle="tooltip" title="{{ $organisation->organisation->tooltip() }}">{{ $organisation->organisation->name }}</a>
                    </td>
                    <td class="visible-sm">{{ $organisation->organisation->type }}</td>
                    <td>{{ $organisation->role }}</td>
                    @if ($campaign->enabled('locations'))
                        <td class="visible-sm">
                            @if ($organisation->organisation->location)
                                <a href="{{ route('locations.show', $organisation->organisation->location_id) }}" data-toggle="tooltip" title="{{ $organisation->organisation->location->tooltip() }}">{{ $organisation->organisation->location->name }}</a>
                            @endif
                        </td>
                    @endif
                    <td class="text-right">
                        @can('organisation', [$model, 'edit'])
                            <a href="{{ route('characters.character_organisations.edit', ['character' => $model, 'organisationMember' => $organisation]) }}" class="btn btn-xs btn-primary"
                               data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('characters.character_organisations.edit', ['character' => $model, 'organisationMember' => $organisation]) }}">
                                <i class="fa fa-pencil"></i> <span class="visible-sm">{{ trans('crud.edit') }}</span>
                            </a>
                        @endcan
                        @can('organisation', [$model, 'delete'])
                            {!! Form::open(['method' => 'DELETE','route' => ['characters.character_organisations.destroy', $model->id, $organisation->id],'style'=>'display:inline']) !!}
                            <button class="btn btn-xs btn-danger">
                                <i class="fa fa-trash" aria-hidden="true"></i> <span class="visible-sm">{{ trans('crud.remove') }}</span>
                            </button>
                            {!! Form::close() !!}
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $r->links() }}
    </div>
</div>