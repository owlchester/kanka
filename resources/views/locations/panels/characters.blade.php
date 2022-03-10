<?php
/**
 * @var \App\Models\Location $model
 * @var \App\Models\Character[] $characters
 */
$filters = [];
$allMembers = true;
if (request()->has('location_id')) {
    $filters['location_id'] = request()->get('location_id');
    $allMembers = false;
}

$characters = $model
        ->allCharacters()
        ->filter($filters)
        ->simpleSort($datagridSorter)
        ->with(['location', 'location.entity', 'families', 'families.entity', 'entity', 'entity.tags'])
        ->paginate();
?>
<div class="box box-solid" id="location-characters">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('locations.show.tabs.characters') }}
        </h3>

        <div class="box-tools">
            @if (request()->has('location_id'))
                <a href="{{ route('locations.characters', $model) }}" class="btn btn-box-tool">
                    <i class="fa fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->allCharacters()->count() }})
                </a>
            @else
                <a href="{{ route('locations.characters', [$model, 'location_id' => $model->id]) }}" class="btn btn-box-tool">
                    <i class="fa fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->characters()->count() }})
                </a>
            @endif
        </div>
    </div>
    <div class="box-body">
        <p class="help-block">
            {{ __('locations.helpers.characters') }}
        </p>

        <div class="row">
            <div class="col-sm-12">
                @include('cruds.datagrids.sorters.simple-sorter', ['target' => '#location-characters'])
            </div>
        </div>

        @if ($characters->count() > 0)
        <div class="table-responsive">
        <table id="characters" class="table table-hover">
            <thead><tr>
                <th class="avatar"><br /></th>
                <th>{{ __('characters.fields.name') }}</th>
                <th>{{ __('characters.fields.type') }}</th>
                @if ($campaign->enabled('families'))
                    <th>{{ __('characters.fields.families') }}</th>
                @endif
                @if ($allMembers)<th>{{ __('crud.fields.location') }}</th>@endif
                @if ($campaign->enabled('races'))
                    <th>{{ __('characters.fields.races') }}</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach ($characters as $character)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $character->getImageUrl(40) }}');" title="{{ $character->name }}" href="{{ route('characters.show', $character->id) }}"></a>
                    </td>
                    <td>
                        {!! $character->tooltipedLink() !!}
                        @if ($character->is_dead)
                            <i class="fa fa-skull" title="{{ __('characters.fields.is_dead') }}"></i>
                        @endif
                        <br />
                        <i>{{ $character->title }}</i>
                    </td>
                    <td>
                        {{ $character->type }}
                    </td>
                    @if ($campaign->enabled('families'))
                        <td>
                            @foreach ($character->families as $family)
                                {!! $family->tooltipedLink() !!}
                            @endforeach
                        </td>
                    @endif
                    @if($allMembers)<td>
                        {!! $character->location->tooltipedLink() !!}
                    </td>@endif
                    @if ($campaign->enabled('races'))
                        <td>
                            @foreach ($character->races as $race)
                                {!! $race->tooltipedLink() !!}
                            @endforeach
                        </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
        </div>
        @endif
    </div>
    @if ($characters->hasPages())
        <div class="box-footer text-right">
            {{ $characters->fragment('location-characters')->appends($filters)->links() }}
        </div>
    @endif
</div>
