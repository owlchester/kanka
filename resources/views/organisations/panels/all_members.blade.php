<?php
/** @var \App\Models\Organisation $model */
$filters = [];
if (request()->has('organisation_id')) {
    $filters['organisation_id'] = request()->get('organisation_id');
}
?>
<div class="box box-flat">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ __('organisations.show.tabs.all_members') }}
        </h2>

        <p class="help-block">
            @if (request()->has('organisation_id'))
                <a href="{{ route('organisations.all-members', $model) }}" class="btn btn-default btn-sm pull-right">
                    <i class="fa fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->allMembers()->has('character')->count() }})
                </a>
            @else
                <a href="{{ route('organisations.all-members', [$model, 'organisation_id' => $model->id]) }}" class="btn btn-default btn-sm pull-right">
                    <i class="fa fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->members()->has('character')->count() }})
                </a>
            @endif
            {{ __('organisations.members.helpers.all_members') }}
        </p>

        <table id="organisation-characters" class="table table-hover">
            <tbody><tr>
                <th class="avatar"><br></th>
                <th>{{ __('characters.fields.name') }}</th>
                @if ($campaign->enabled('locations'))
                <th>{{ __('characters.fields.location') }}</th>
                @endif
                @if (isset($showOrg) && $showOrg)
                    <th>{{ __('organisations.members.fields.organisation') }}</th>
                @endif
                <th>{{ __('organisations.members.fields.role') }}</th>
                <th>{{ __('characters.fields.age') }}</th>
                @if ($campaign->enabled('races'))
                <th>{{ __('characters.fields.race') }}</th>
                @endif
                <th>{{ __('characters.fields.sex') }}</th>
                <th>{{ __('characters.fields.is_dead') }}</th>
                <th><br /></th>
            </tr>
            <?php $r = $model->allMembers()
                ->filter($filters)
                ->has('character')
                ->with([
                    'character', 'character.race', 'character.location', 'character.family', 'organisation',
                    'character.entity', 'character.entity.tags'
                ])
                ->join('characters', 'characters.id', '=', 'character_id')
                ->orderBy('characters.name', 'asc')
                ->paginate(); ?>
            @foreach ($r as $relation)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $relation->character->getImageUrl(true) }}');" title="{{ $relation->character->name }}" href="{{ route('characters.show', $relation->character->id) }}"></a>
                    </td>
                    <td>
                        {!! $relation->character->tooltipedLink() !!}
                    </td>
                    @if ($campaign->enabled('locations'))
                    <td>
                        @if ($relation->character->location)
                            {!! $relation->character->location->tooltipedLink() !!}
                        @endif
                    </td>
                    @endif
                    @if (isset($showOrg) && $showOrg)
                    <td>{{ $relation->organisation->name }}</td>
                    @endif
                    <td>{{ $relation->role }}</td>
                    <td>{{ $relation->character->age }}</td>
                    @if ($campaign->enabled('races'))
                        <td>
                            @if ($relation->character->race)
                                {!! $relation->character->race->tooltipedLink() !!}
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
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $r->fragment('tab_member')->links() }}
    </div>
</div>