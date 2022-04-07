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
            <a href="#" class="btn btn-box-tool" data-toggle="modal" data-target="#help-modal">
                <i class="fa fa-question-circle"></i> {{ __('crud.actions.help') }}
            </a>
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

        <div class="row">
            <div class="col-sm-12 col-md-6">
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
                <tr class="{{ $character->rowClasses() }}">
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $character->getImageUrl(40) }}');" title="{{ $character->name }}" href="{{ route('characters.show', $character->id) }}"></a>
                    </td>
                    <td>
                        @if ($character->is_private)
                            <i class="fas fa-lock" title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i>
                        @endif
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

@section('modals')
    @parent

    <div class="modal fade" id="help-modal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('crud.delete_modal.close') }}"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">
                        {{ __('crud.actions.help') }}
                    </h4>
                </div>
                <div class="modal-body">
                    <p>
                        {{ __('locations.helpers.characters') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
