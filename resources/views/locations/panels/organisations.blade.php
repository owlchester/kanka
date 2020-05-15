<?php
/** @var \App\Models\Location $model */
$filters = [];
if (request()->has('location_id')) {
    $filters['location_id'] = request()->get('location_id');
}
?>
<div class="box box-solid">
    <div class="box-body">
        <h2 class="page-header with-border">
            {{ trans('locations.show.tabs.organisations') }}
        </h2>

        <p class="help-block export-hidden">

            @if (request()->has('location_id'))
                <a href="{{ route('locations.organisations', $model) }}" class="btn btn-default btn-sm pull-right">
                    <i class="fa fa-filter"></i> {{ __('crud.filters.all') }} ({{ $model->allOrganisations()->count() }})
                </a>
            @else
                <a href="{{ route('locations.organisations', [$model, 'location_id' => $model->id]) }}" class="btn btn-default btn-sm pull-right">
                    <i class="fa fa-filter"></i> {{ __('crud.filters.direct') }} ({{ $model->organisations()->count() }})
                </a>
            @endif
            {{ trans('locations.helpers.organisations') }}
        </p>

        <?php  $r = $model->allOrganisations()->filter($filters)->orderBy('name', 'ASC')->with(['members'])->paginate(); ?>
        <p class="export-{{ $r->count() === 0 ? 'visible export-hidden' : 'visible' }}">{{ trans('locations.show.tabs.organisations') }}</p>
        <table id="items" class="table table-hover {{ $r->count() === 0 ? 'export-hidden' : '' }}">
            <tbody><tr>
                <th class="avatar"><br /></th>
                <th>{{ trans('organisations.fields.name') }}</th>
                <th>{{ trans('organisations.fields.type') }}</th>
                @if ($campaign->enabled('characters'))<th>{{ trans('organisations.fields.members') }}</th>@endif
                <th>&nbsp;</th>
            </tr>
            @foreach ($r as $org)
                <tr>
                    <td>
                        <a class="entity-image" style="background-image: url('{{ $org->getImageUrl(40) }}');" title="{{ $org->name }}" href="{{ route('items.show', $org->id) }}"></a>
                    </td>
                    <td>
                        {!! $org->tooltipedLink() !!}
                    </td>
                    <td>{{ $org->type }}</td>

                    @if ($campaign->enabled('characters'))<td>
                        {{ $org->members()->count() }}
                    </td>@endif
                    <td class="text-right">
                        <a href="{{ route('organisations.show', [$org]) }}" class="btn btn-xs btn-primary">
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
