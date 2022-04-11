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
    <div class="box-header with-border">
        <h3 class="box-title">
            {{ __('maps.show.tabs.maps') }}
        </h3>
    </div>
    <div class="box-body">

        <p class="help-block">{{ __('maps.helpers.descendants') }}</p>

        <div class="row">
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

        <table id="maps" class="table table-hover margin-top ">
            <thead>
                <tr>
                    <th class="avatar"><br /></th>
                    <th>{{ __('maps.fields.name') }}</th>
                    <th>{{ __('crud.fields.map') }}</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($r as $map)
                <tr class="{{ $map->rowClasses() }}">
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $map->getImageUrl(40) }}');" title="{{ $map->name }}" href="{{ route('maps.show', $map->id) }}"></a>
                    </td>
                    <td>
                        @if ($map->is_private) <i class="fas fa-lock" title="{{ __('crud.is_private') }}" data-toggle="tooltip"></i> @endif
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
    </div>
    @if($r->hasPages())
        <div class="box-footer text-right">
            {{ $r->fragment('map-maps')->links() }}
        </div>
    @endif
</div>
