<?php
$filters = [];
if (request()->has('parent_location_id')) {
    $filters['parent_location_id'] = request()->get('parent_location_id');
}

$r = $model->descendants()
        ->filter($filters)
        ->with('parent')
        ->simpleSort($datagridSorter)
        ->paginate();
?><div class="box box-solid" id="location-locations">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ __('locations.show.tabs.locations') }}
        </h2>

        <p class="help-block">
            {{ __('locations.helpers.descendants') }}
        </p>

        <div class="row export-hidden">
            <div class="col-md-6">
                @include('cruds.datagrids.sorters.simple-sorter', ['target' => '#location-locations'])
            </div>
            <div class="col-md-6 text-right">
                @if (request()->has('parent_location_id'))
                    <a href="{{ route('locations.locations', [$model, '#location-locations']) }}" class="btn btn-default btn-sm pull-right">
                        <i class="fa fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->descendants()->count() }})
                    </a>
                @else
                    <a href="{{ route('locations.locations', [$model, 'parent_location_id' => $model->id, '#location-locations']) }}" class="btn btn-default btn-sm pull-right">
                        <i class="fa fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->locations()->count() }})
                    </a>
                @endif
            </div>
        </div>

        <p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ __('locations.show.tabs.locations') }}</p>
        <table id="locations" class="table table-hover {{ $r->count() === 0 ? 'export-hidden' : '' }}">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ __('locations.fields.name') }}</th>
                <th>{{ __('locations.fields.type') }}</th>
                <th>{{ __('locations.fields.location') }}</th>
            </tr>
            @foreach ($r as $model)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $model->getImageUrl(40) }}');" title="{{ $model->name }}" href="{{ route('locations.show', $model->id) }}"></a>
                    </td>
                    <td>
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

        {{ $r->fragment('location-locations')->appends($filters)->links() }}
    </div>
</div>
