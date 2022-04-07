<?php
/**
 * @var \App\Models\Location[] $locations
 */
$filters = [];
if (request()->has('parent_location_id')) {
    $filters['parent_location_id'] = request()->get('parent_location_id');
}

$locations = $model->descendants()
        ->filter($filters)
        ->with('parent')
        ->simpleSort($datagridSorter)
        ->paginate();
?><div class="box box-solid" id="location-locations">
    <div class="box-header">
        <h3 class="box-title">
            {{ __('locations.show.tabs.locations') }}
        </h3>
        <div class="box-tools">
            <a href="#" class="btn btn-box-tool" data-toggle="modal" data-target="#help-modal">
                <i class="fa fa-question-circle"></i> {{ __('crud.actions.help') }}
            </a>

            @if (request()->has('parent_location_id'))
                <a href="{{ route('locations.locations', [$model, '#location-locations']) }}" class="btn btn-box-tool">
                    <i class="fa fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->descendants()->count() }})
                </a>
            @else
                <a href="{{ route('locations.locations', [$model, 'parent_location_id' => $model->id, '#location-locations']) }}" class="btn btn-box-tool">
                    <i class="fa fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->locations()->count() }})
                </a>
            @endif
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                @include('cruds.datagrids.sorters.simple-sorter', ['target' => '#location-locations'])
            </div>
        </div>

        @if($locations->count() > 0)
        <table id="locations" class="table table-hover">
            <thead><tr>
                <th class="avatar"><br /></th>
                <th>{{ __('locations.fields.name') }}</th>
                <th>{{ __('locations.fields.type') }}</th>
                <th>{{ __('locations.fields.location') }}</th>
            </tr></thead>
            <tbody>
            @foreach ($locations as $model)
                <tr class="{{ $model->rowClasses() }}">
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $model->getImageUrl(40) }}');" title="{{ $model->name }}" href="{{ route('locations.show', $model->id) }}"></a>
                    </td>
                    <td>
                        @if ($model->is_private)
                            <i class="fas fa-lock" title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i>
                        @endif
                        {!! $model->tooltipedLink() !!}
                    </td>
                    <td>
                        {{ $model->type }}
                    </td>
                    <td>
                        @if ($model->parent)
                            {!! $model->parent->tooltipedLink() !!}
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @endif
    </div>
    @if ($locations->hasPages())
        <div class="box-footer text-right">
            {{ $locations->fragment('location-locations')->appends($filters)->links() }}
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
                        {{ __('locations.helpers.location_list') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
