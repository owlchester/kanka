<?php
/**
 * @var \App\Models\Organisation $model
 * @var \App\Models\OrganisationMember $relation
 */
$filters = [];
if (request()->has('organisation_id')) {
    $filters['organisation_id'] = request()->get('organisation_id');
}
$hasOrg = request()->has('organisation_id');
?>
<div class="box box-solid">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('organisations.fields.members') }}
        </h3>
    </div>
    <div class="box-body">

        <p class="help-block">
            {{ __('organisations.members.helpers.members') }}
        </p>

        <div class="row">
            <div class="col-md-6">
                @include('cruds.datagrids.sorters.simple-sorter')
            </div>
            <div class="col-md-6 text-right">
                @if ($hasOrg)
                    <a href="{{ route('organisations.members', $model) }}" class="btn btn-default btn-sm">
                        <i class="fa fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->allMembers()->has('character')->count() }})
                    </a>
                @else
                    <a href="{{ route('organisations.members', [$model, 'organisation_id' => $model->id]) }}" class="btn btn-default btn-sm">
                        <i class="fa fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->members()->has('character')->count() }})
                    </a>
                @endif
            </div>
        </div>

        <table id="organisation-characters" class="table table-hover">
            <tbody><tr>
                <th class="avatar"><br></th>
                <th>{{ __('characters.fields.name') }}</th>
                @if ($campaign->enabled('locations'))
                <th class="hidden-sm hidden-xs">{{ __('characters.fields.location') }}</th>
                @endif
                @if (!$hasOrg)<th>{{ __('organisations.members.fields.organisation') }}</th>@endif
                <th>{{ __('organisations.members.fields.role') }}</th>
                @if ($campaign->enabled('races'))
                <th class="hidden-sm hidden-xs">{{ __('characters.fields.race') }}</th>
                @endif
                <th>{{ __('characters.fields.is_dead') }}</th>
                <th></th>
                <th class="text-right">
                    @can('member', $model)
                        <a href="{{ route('organisations.organisation_members.create', ['organisation' => $model->id]) }}" class="btn btn-primary btn-sm"
                           data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('organisations.organisation_members.create', $model->id) }}">
                            <i class="fa fa-plus"></i> <span class="hidden-sm hidden-xs">{{ __('organisations.members.actions.add') }}</span>
                        </a>
                    @endcan
                </th>
            </tr>
            <?php $r = $model->allMembers()
                ->filter($filters)
                ->has('character')
                ->with([
                    'character', 'character.race', 'character.location', 'character.family', 'organisation',
                    'character.entity'
                ])
                ->simpleSort($datagridSorter)
                ->paginate();?>
            @foreach ($r as $relation)
                <tr class="{{ $relation->character->rowClasses() }}">
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $relation->character->getImageUrl(40) }}');" title="{{ $relation->character->name }}" href="{{ route('characters.show', $relation->character->id) }}"></a>
                    </td>
                    <td>
                        @if ($relation->character->is_private)
                            <i class="fas fa-lock" title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i>
                        @endif
                        {!! $relation->character->tooltipedLink() !!}<br />
                        <i>{{ $relation->character->title }}</i>
                    </td>
                    @if ($campaign->enabled('locations'))
                    <td class="hidden-sm hidden-xs">
                        @if ($relation->character->location)
                            {!! $relation->character->location->tooltipedLink() !!}
                        @endif
                    </td>
                    @endif
                    @if (!$hasOrg)
                    <td>
                        {!! $relation->organisation->tooltipedLink() !!}
                    </td>
                    @endif
                    <td>{{ $relation->role }}</td>
                    @if ($campaign->enabled('races'))
                        <td class="hidden-sm hidden-xs">
                            @foreach ($relation->character->races as $race)
                                {!! $race->tooltipedLink() !!}
                            @endforeach
                        </td>
                    @endif
                    <td>@if ($relation->character->is_dead)<span class="ra ra-skull"></span>@endif</td>
                    <td>
                        @if (Auth::check() && Auth::user()->isAdmin())
                            @if ($relation->is_private == true)
                                <i class="fas fa-lock" title="{{ __('crud.is_private') }}"></i>
                            @endif
                        @endif
                    </td>
                    <td class="text-right">
                        @can('member', $model)
                            <a href="{{ route('organisations.organisation_members.edit', [$model, $relation]) }}"
                               class="btn btn-xs btn-primary" data-toggle="ajax-modal" data-target="#entity-modal"
                               data-url="{{ route('organisations.organisation_members.edit', [$model, $relation]) }}"
                               title=" {{ __('crud.edit') }}"
                            >
                                <i class="fa fa-edit"></i>
                            </a>

                            <button class="btn btn-xs btn-danger delete-confirm" data-toggle="modal" data-name="{{ $relation->character->name }}"
                                    data-target="#delete-confirm" data-delete-target="delete-form-{{ $relation->id }}"
                                    title="{{ __('crud.remove') }}">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                            {!! Form::open(['method' => 'DELETE', 'route' => ['organisations.organisation_members.destroy', $model->id, $relation->id], 'style' => 'display:inline', 'id' => 'delete-form-' . $relation->id]) !!}
                            {!! Form::close() !!}
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $r->fragment('tab_member')->links() }}
    </div>
</div>
