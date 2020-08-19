<?php
/**
 * @var \App\Models\Location $model
 * @var \App\Models\Family $family
 */
$filters = [];
if (request()->has('location_id')) {
    $filters['location_id'] = request()->get('location_id');
}
?>
<div class="box box-solid">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('locations.show.tabs.families') }}
        </h2>


        <p class="help-block export-hidden">
            {{ trans('locations.helpers.families') }}
        </p>


        <div class="row export-hidden">
            <div class="col-md-6">
                @include('cruds.datagrids.sorters.simple-sorter')
            </div>
            <div class="col-md-6 text-right">

                @if (request()->has('location_id'))
                    <a href="{{ route('locations.families', $model) }}" class="btn btn-default btn-sm pull-right">
                        <i class="fa fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->allFamilies()->count() }})
                    </a>
                @else
                    <a href="{{ route('locations.families', [$model, 'location_id' => $model->id]) }}" class="btn btn-default btn-sm pull-right">
                        <i class="fa fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->families()->count() }})
                    </a>
                @endif
            </div>
        </div>

        <?php  $r = $model->allFamilies()->filter($filters)->simpleSort($datagridSorter)->with(['location', 'family', 'entity', 'entity.tags'])->paginate(); ?>
        <p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ trans('locations.show.tabs.families') }}</p>
        <table id="families" class="table table-hover margin-top {{ $r->count() === 0 ? 'export-hidden' : '' }}">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ trans('families.fields.name') }}</th>
                @if ($campaign->enabled('locations'))
                    <th>{{ trans('crud.fields.location') }}</th>
                @endif
                <th>{{ trans('crud.fields.family') }}</th>
                <th>{{ trans('crud.fields.type') }}</th>
                <th>&nbsp;</th>
            </tr>
            @foreach ($r as $family)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $family->getImageUrl(40) }}');" title="{{ $family->name }}" href="{{ route('families.show', $family->id) }}"></a>
                    </td>
                    <td>
                        {!! $family->tooltipedLink() !!}
                    </td>
                    @if ($campaign->enabled('locations'))
                        <td>
                            @if ($family->location)
                                {!! $family->location->tooltipedLink() !!}
                            @endif
                        </td>
                    @endif
                    <td>
                        @if ($family->family)
                            {!! $family->family->tooltipedLink() !!}
                        @endif
                    </td>
                    <td>{{ $family->type }}</td>
                    <td class="text-right">
                        <a href="{{ route('families.show', [$family]) }}" class="btn btn-xs btn-primary">
                            <i class="fa fa-eye" aria-hidden="true"></i> {{ trans('crud.view') }}
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $r->links() }}
    </div>
</div>
