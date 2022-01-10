<?php
/**
 * @var \App\Models\Organisation $model
 * @var \App\Models\OrganisationMember[] $members
 */
$filters = [];
$allMembers = true;
if (!request()->has('all_members')) {
    $filters['organisation_id'] = $model->id;
    $allMembers = false;
}
$datagridSorter = new \App\Datagrids\Sorters\OrganisationCharacterSorter();
$datagridSorter->request(request()->all());

$filterCount = !$allMembers ? $model->allMembers()->has('character')->count() : $model->members()->has('character')->count();


$members = $model->allMembers()
        ->filter($filters)
        ->has('character')
        ->with([
            'character', 'character.location', 'organisation',
            'character.entity', 'organisation.entity',
            'parent', 'parent.character'
        ])
        ->simpleSort($datagridSorter)
        ->paginate();
?>
<div class="box box-solid" id="organisation-members">
    <div class="box-header with-border">
        <h3 class="box-title">{{ __('organisations.fields.members') }}</h3>

        <div class="box-tools">
            @if (!$allMembers)
                <a href="{{ route('organisations.show', [$model, 'all_members' => true, '#organisation-members']) }}" class="btn btn-default btn-sm">
                    <i class="fa fa-filter"></i>
                    <span class="hidden-xs hidden-sm">
                        {{ __('crud.filters.lists.desktop.all', ['count' => $filterCount]) }}
                    </span>
                    <span class="visible-xs-inline visible-sm-inline">
                        {{ __('crud.filters.lists.mobile.all', ['count' => $filterCount]) }}
                    </span>
                </a>
            @else
                <a href="{{ route('organisations.show', [$model, '#organisation-members']) }}" class="btn btn-default btn-sm">
                    <i class="fa fa-filter"></i>

                    <span class="hidden-xs hidden-sm">
                        {{ __('crud.filters.lists.desktop.filtered', ['count' => $filterCount]) }}
                    </span>
                    <span class="visible-xs-inline visible-sm-inline">
                        {{ __('crud.filters.lists.mobile.filtered', ['count' => $filterCount]) }}
                    </span>
                </a>
            @endif

            @can('member', $model)
                <a href="{{ route('organisations.organisation_members.create', ['organisation' => $model->id]) }}" class="btn btn-primary btn-sm"
                   data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('organisations.organisation_members.create', $model->id) }}">
                    <i class="fa fa-plus"></i> <span class="hidden-sm hidden-xs">{{ __('organisations.members.actions.add') }}</span>
                </a>
            @endcan
        </div>
    </div>

    @if ($members->count() === 0)
        <div class="box-body">

            <p class="help-block">
                {{ __('organisations.members.helpers.' . ($allMembers ? 'all_' : null) . 'members') }}
            </p>
        </div>
    @else
    <div class="box-body no-padding">

        @include('cruds.datagrids.sorters.simple-sorter', ['target' => '#organisation-members'])

        <div class="table-responsive">
        <table id="organisation-characters" class="table table-hover">
            <thead>
                <tr>
                    <th class="avatar"><br></th>
                    <th>{{ __('characters.fields.name') }}</th>
                    @if ($campaign->enabled('locations'))
                    <th class="hidden-sm hidden-xs">{{ __('characters.fields.location') }}</th>
                    @endif
                    @if ($allMembers)<th>{{ __('organisations.members.fields.organisation') }}</th>@endif
                    <th>{{ __('organisations.members.fields.role') }}</th>
                    <th class="hidden-sm hidden-xs">{{ __('organisations.members.fields.parent') }}</th>
                    @if (auth()->check() && auth()->user()->isAdmin())
                    <th></th>
                    @endif
                    <th>
                        <i class="fas fa-star" title="{{ __('organisations.members.fields.pinned') }}" data-toggle="tooltip"></i>
                    </th>
                    <th class="text-right">

                    </th>
                </tr>
            </thead>
            <tbody>
            @foreach ($members as $relation)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $relation->character->getImageUrl(40) }}');" title="{{ $relation->character->name }}" href="{{ route('characters.show', $relation->character->id) }}"></a>
                    </td>
                    <td>
                        @if ($relation->character->is_private) <i class="fas fa-lock" title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i> @endif
                        {!! $relation->character->tooltipedLink() !!}
                        @if ($relation->character->is_dead)<span class="ra ra-skull" title="{{ __('characters.fields.is_dead') }}"></span>@endif
                        <br />
                        <i>{{ $relation->character->title }}</i>
                    </td>
                    @if ($campaign->enabled('locations'))
                    <td class="hidden-sm hidden-xs">
                        @if ($relation->character->location)
                            {!! $relation->character->location->tooltipedLink() !!}
                        @endif
                    </td>
                    @endif
                    @if ($allMembers)
                    <td>
                        {!! $relation->organisation->tooltipedLink() !!}
                    </td>
                    @endif
                    <td>
                        @if ($relation->inactive())
                            <i class="fas fa-user-slash" title="{{ __('organisations.members.status.inactive') }}" data-toggle="tooltip"></i>
                        @elseif ($relation->unknown())
                            <i class="fas fa-question" title="{{ __('organisations.members.status.unknown') }}" data-toggle="tooltip"></i>
                        @endif
                        {{ $relation->role }}
                    </td>
                    <td class="hidden-sm hidden-xs">
                        @if ($relation->parent && $relation->parent->character)
                            {!! $relation->parent->character->tooltipedLink() !!}
                        @endif
                        </td>
                    @include('cruds.partials.private', ['model' => $relation])
                    <td>
                        @if ($relation->pinned())
                            @if ($relation->pinnedToCharacter())
                                <i class="fa fa-user" data-toggle="tooltip" title="{{ __('organisations.members.pinned.character') }}"></i>
                            @elseif ($relation->pinnedToOrganisation())
                                <i class="ra ra-hood" data-toggle="tooltip" title="{{ __('organisations.members.pinned.organisation') }}"></i>
                            @else
                                <i class="fas fa-star" data-toggle="tooltip" title="{{ __('organisations.members.pinned.both') }}"></i>
                            @endif
                        @endif
                    </td>
                    <td class="text-right">
                        @can('member', $model)
                            <div class="dropdown">
                                <a class="dropdown-toggle btn btn-xs btn-default" data-toggle="dropdown" aria-expanded="false" data-placement="right" href="#">
                                    <i class="fa fa-ellipsis-h" data-tree="escape"></i>
                                    <span class="sr-only">{{ __('crud.actions.actions') }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                    <li>
                                        <a href="{{ route('organisations.organisation_members.edit', [$model, $relation]) }}"
                                           data-toggle="ajax-modal" data-target="#entity-modal"
                                           data-url="{{ route('organisations.organisation_members.edit', [$model, $relation]) }}">
                                            <i class="fa fa-pencil"></i> {{ __('crud.edit') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#" class="text-red delete-confirm" data-toggle="modal" data-name="{!! $relation->character->name !!}"
                                           data-target="#delete-confirm" data-delete-target="delete-form-{{ $relation->id }}">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                            {{ __('crud.remove') }}
                                        </a>

                                        {!! Form::open(['method' => 'DELETE', 'route' => ['organisations.organisation_members.destroy', $model->id, $relation->id], 'style' => 'display:inline', 'id' => 'delete-form-' . $relation->id]) !!}
                                        {!! Form::close() !!}
                                    </li>
                                </ul>
                            </div>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
    @if ($members->hasPages())
        <div class="box-footer text-right">
            {{ $members->fragment('organisation-members')->appends('all_members', request()->get('all_members'))->links() }}

        </div>
    @endif
    @endif
</div>
