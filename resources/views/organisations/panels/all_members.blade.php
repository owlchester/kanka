<div class="box box-flat">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('organisations.show.tabs.all_members') }}
        </h2>

        <p class="help-block">{{ trans('organisations.members.helpers.all_members') }}</p>

        <table id="organisation-characters" class="table table-hover">
            <tbody><tr>
                <th class="avatar"><br></th>
                <th>{{ trans('characters.fields.name') }}</th>
                @if ($campaign->enabled('locations'))
                <th>{{ trans('characters.fields.location') }}</th>
                @endif
                <th>{{ trans('organisations.members.fields.role') }}</th>
                <th>{{ trans('characters.fields.age') }}</th>
                @if ($campaign->enabled('races'))
                <th>{{ trans('characters.fields.race') }}</th>
                @endif
                <th>{{ trans('characters.fields.sex') }}</th>
                <th>{{ trans('characters.fields.is_dead') }}</th>
                <th><br /></th>
            </tr>
            <?php $r = $model->allMembers()->acl()->has('character')->with('character', 'character.location')->paginate();?>
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
                    <td>@if ($relation->character->is_dead)<span class="fa fa-check-circle"></span>@endif</td>
                    <td>
                        @if (Auth::check() && Auth::user()->isAdmin())
                            @if ($relation->is_private == true)
                                <i class="fa fa-lock" title="{{ trans('crud.is_private') }}"></i>
                            @endif
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $r->fragment('tab_member')->links() }}
    </div>
</div>