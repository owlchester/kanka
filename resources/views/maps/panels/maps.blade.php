<?php
$filters = [];
if (request()->has('map_id')) {
    $filters['map_id'] = request()->get('map_id');
}
$r = $model->descendants()
        ->filter($filters)
        ->simpleSort($datagridSorter)
        ->with('parent')
        ->paginate();
?>
<div class="box box-solid" id="map-maps">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('maps.show.tabs.maps') }}
        </h2>

        <p class="help-block">{{ trans('maps.helpers.descendants') }}</p>

        <div class="row export-hidden">
            <div class="col-md-6">
                @include('cruds.datagrids.sorters.simple-sorter', ['target' => 'map-maps'])
            </div>
            <div class="col-md-6 text-right">
                @if (request()->has('map_id'))
                    <a href="{{ route('maps.maps', [$model, '#map-maps']) }}" class="btn btn-default btn-sm pull-right">
                        <i class="fa fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->descendants->count() }})
                    </a>
                @else
                    <a href="{{ route('maps.maps', [$model, 'map_id' => $model->id, '#map-maps']) }}" class="btn btn-default btn-sm pull-right">
                        <i class="fa fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->maps->count() }})
                    </a>
                @endif
            </div>
        </div>

        <p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ trans('maps.show.tabs.maps') }}</p>
        <table id="maps" class="table table-hover margin-top {{ $r->count() === 0 ? 'export-hidden' : '' }}">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ trans('maps.fields.name') }}</th>
                <th>{{ trans('crud.fields.map') }}</th>
            </tr>
            @foreach ($r as $map)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $map->getImageUrl(40) }}');" title="{{ $map->name }}" href="{{ route('maps.show', $map->id) }}"></a>
                    </td>
                    <td>
                        {!! $map->tooltipedLink() !!}
                    </td>
                    <td>
                        @if ($map->parent)
                            {!! $map->parent->tooltipedLink() !!}
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $r->fragment('map-maps')->links() }}
    </div>
</div>
