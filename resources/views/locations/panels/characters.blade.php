<?php
/**
 * @var \App\Models\Location $model
 * @var \App\Models\Character $character
 */
$filters = [];
if (request()->has('location_id')) {
    $filters['location_id'] = request()->get('location_id');
}
?>
<div class="box box-solid" id="location-characters">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ __('locations.show.tabs.characters') }}
        </h2>


        <p class="help-block export-hidden">
            {{ __('locations.helpers.characters') }}
        </p>

        <div class="row export-hidden">
            <div class="col-md-6">
                @include('cruds.datagrids.sorters.simple-sorter', ['target' => '#location-characters'])
            </div>
            <div class="col-md-6 text-right">

                @if (request()->has('location_id'))
                    <a href="{{ route('locations.characters', $model) }}" class="btn btn-default btn-sm pull-right">
                        <i class="fa fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->allCharacters()->count() }})
                    </a>
                @else
                    <a href="{{ route('locations.characters', [$model, 'location_id' => $model->id]) }}" class="btn btn-default btn-sm pull-right">
                        <i class="fa fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->characters()->count() }})
                    </a>
                @endif
            </div>
        </div>

        <?php  $r = $model->allCharacters()->filter($filters)->simpleSort($datagridSorter)->with(['location', 'family', 'entity', 'entity.tags'])->paginate(); ?>
        <p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ __('locations.show.tabs.characters') }}</p>
        <table id="characters" class="table table-hover {{ $r->count() === 0 ? 'export-hidden' : '' }}">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ __('characters.fields.name') }}</th>
                @if ($campaign->enabled('families'))
                    <th>{{ __('characters.fields.family') }}</th>
                @endif
                <th>{{ __('crud.fields.location') }}</th>
                @if ($campaign->enabled('races'))
                    <th>{{ __('characters.fields.race') }}</th>
                @endif
                <th>&nbsp;</th>
            </tr>
            @foreach ($r as $character)
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
                    @if ($campaign->enabled('families'))
                        <td>
                            @if ($character->family)
                                {!! $character->family->tooltipedLink() !!}
                            @endif
                        </td>
                    @endif
                    <td>
                        {!! $character->location->tooltipedLink() !!}
                    </td>
                    @if ($campaign->enabled('races'))
                        <td>
                            @if ($character->race)
                                {!! $character->race->tooltipedLink() !!}
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

        {{ $r->fragment('location-characters')->appends($filters)->links() }}
    </div>
</div>
