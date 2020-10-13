<?php
/**
 * @var \App\Models\Race $model
 * @var \App\Models\Character $character
 */
$filters = [];
$allMembers = true;
if (!request()->has('all_members')) {
    $filters['race_id'] = $model->id;
    $allMembers = false;
}
$datagridSorter = new \App\Datagrids\Sorters\RaceCharacterSorter();
$datagridSorter->request(request()->all());

?>
<div class="box box-solid">
    <div class="box-header with-border">
        <h3 class="box-title">{{ __('races.show.tabs.characters') }}</h3>

        <div class="box-tools pull-right">
            @if (!$allMembers)
                <a href="{{ route('races.show', [$model, 'all_members' => true]) }}" class="btn btn-default btn-sm">
                    <i class="fa fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->allCharacters()->has('entity')->count() }})
                </a>
            @else
                <a href="{{ route('races.show', $model) }}" class="btn btn-default btn-sm">
                    <i class="fa fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->characters()->has('entity')->count() }})
                </a>
            @endif
        </div>
    </div>
    <div class="box-body">

        <p class="help-block export-hidden">
            {{ __('races.characters.helpers.' . ($allMembers ? 'all_' : null) . 'characters') }}
        </p>

        <div class="export-hidden">
            @include('cruds.datagrids.sorters.simple-sorter')
        </div>

        <table id="characters" class="table table-hover">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ __('characters.fields.name') }}</th>
                @if ($campaign->enabled('locations'))
                    <th>{{ __('crud.fields.location') }}</th>
                @endif
                @if ($campaign->enabled('families'))
                    <th>{{ __('characters.fields.family') }}</th>
                @endif
                <th>&nbsp;</th>
            </tr>

<?php
$r = $model->allCharacters()
    ->has('entity')
    ->with(['family', 'location', 'entity'])
    ->filter($filters)
    ->simpleSort($datagridSorter)
    ->paginate(); ?>
            @foreach ($r as $character)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $character->getImageUrl(40) }}');" title="{{ $character->name }}" href="{{ route('characters.show', $character->id) }}"></a>
                    </td>
                    <td>
                        {!! $character->tooltipedLink() !!}
                    </td>
                    @if ($campaign->enabled('locations'))
                        <td>
                            @if ($character->location)
                                {!! $character->location->tooltipedLink() !!}
                            @endif
                        </td>
                    @endif
                    @if ($campaign->enabled('families'))
                    <td>
                        @if ($character->family)
                            {!! $character->family->tooltipedLink() !!}
                        @endif
                    </td>
                    @endif
                    <td class="text-right">
                        <a href="{{ route('characters.show', [$character]) }}" class="btn btn-xs btn-primary">
                            <i class="fa fa-eye" aria-hidden="true"></i> {{ __('crud.view') }}
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $r->appends('all_members', request()->get('all_members'))->links() }}
    </div>
    </div>
