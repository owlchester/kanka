<?php
/** @var \App\Models\Organisation $model */
?>
<div class="box box-flat">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ __('organisations.show.tabs.members') }}
        </h2>

        <p class="help-block">
            {{ __('organisations.members.helpers.direct_members') }}
        </p>

        <table id="organisation-characters" class="table table-hover">
            <tbody><tr>
                <th class="avatar"><br></th>
                <th>{{ __('characters.fields.name') }}</th>
                @if ($campaign->enabled('locations'))
                <th>{{ __('characters.fields.location') }}</th>
                @endif
                <th>{{ __('organisations.members.fields.role') }}</th>
                <th>{{ __('characters.fields.age') }}</th>
                @if ($campaign->enabled('races'))
                <th>{{ __('characters.fields.race') }}</th>
                @endif
                <th>{{ __('characters.fields.sex') }}</th>
                <th>{{ __('characters.fields.is_dead') }}</th>
                <th><br /></th>
                <th class="text-right">
                    @can('member', $model)
                        <a href="{{ route('organisations.organisation_members.create', ['organisation' => $model->id]) }}" class="btn btn-primary btn-sm"
                           data-toggle="ajax-modal" data-target="#entity-modal" data-url="{{ route('organisations.organisation_members.create', $model->id) }}">
                            <i class="fa fa-plus"></i> {{ __('organisations.members.actions.add') }}
                        </a>
                    @endcan
                </th>
            </tr>
            <?php $r = $model->members()->acl()->has('character')->with('character', 'character.location')->paginate();?>
            @foreach ($r->sortBy('character.name') as $relation)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $relation->character->getImageUrl(true) }}');" title="{{ $relation->character->name }}" href="{{ route('characters.show', $relation->character->id) }}"></a>
                    </td>
                    <td>
                        <a href="{{ route('characters.show', $relation->character->id) }}" data-toggle="tooltip" title="{{ $relation->character->tooltip() }}">{{ $relation->character->name }}</a>
                    </td>
                    @if ($campaign->enabled('locations'))
                    <td>
                        @if ($relation->character->location)
                            <a href="{{ route('locations.show', $relation->character->location_id) }}" data-toggle="tooltip" title="{{ $relation->character->location->tooltip() }}">{{ $relation->character->location->name }}</a>
                        @endif
                    </td>
                    @endif
                    <td>{{ $relation->role }}</td>
                    <td>{{ $relation->character->age }}</td>
                    @if ($campaign->enabled('races'))
                        <td>
                            @if ($relation->character->race)
                                <a href="{{ route('races.show', $relation->character->race_id) }}" data-toggle="tooltip" title="{{ $relation->character->race->tooltip() }}">{{ $relation->character->race->name }}</a>
                            @endif
                        </td>
                    @endif
                    <td>{{ $relation->character->sex }}</td>
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
                            <a href="{{ route('organisations.organisation_members.edit', ['organisation' => $model, 'organisationMember' => $relation]) }}"
                               class="btn btn-xs btn-primary" data-toggle="ajax-modal" data-target="#entity-modal" 
                               data-url="{{ route('organisations.organisation_members.edit', ['organisation' => $model, 'organisationMember' => $relation]) }}"
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