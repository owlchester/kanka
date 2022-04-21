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

/*$characters = $model
        ->allCharacters()
        ->filter($filters)
        ->simpleSort($datagridSorter)
        ->with(['location', 'location.entity', 'families', 'families.entity', 'entity', 'entity.tags'])
        ->paginate();*/
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
    <div class="box-body no-padding">

        <div id="datagrid-parent" class="table-responsive">
            @include('locations.panels._characters')
        </div>

        @if ($rows->count() > 0)

        @endif
    </div>
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
